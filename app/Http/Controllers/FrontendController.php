<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\UserVisit;
use App\Services\ExotelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Pool;

class FrontendController extends Controller
{
  public function landing()
  {
    return view('frontend.landing');
  }

  public function index(Request $request)
  {
    // session()->flush();
    $hospital = Hospital::where('status','active');
    if ($request->search) {
      $search = $request->search;
      $hospital->where(function ($query) use ($search) {
        $query->where('hospital_name', 'LIKE', "%{$search}%")
        
           ->orWhere('area', 'LIKE', "%{$search}%")
          ->orWhere('pincode', 'LIKE', "%{$search}%");
      });
    }
    

    $hospital = $hospital->limit(3)->get();

    return view('frontend.home', compact('hospital'));
  }

  public function loadMore(Request $request)
  {
      $offset = $request->offset ?? 0;
      $search = $request->search;

      $query = Hospital::where('status', 'active');

      if ($search) {
          $query->where(function ($q) use ($search) {
              $q->where('hospital_name', 'LIKE', "%{$search}%")
                ->orWhere('area', 'LIKE', "%{$search}%")
                ->orWhere('pincode', 'LIKE', "%{$search}%");
          });
      }

      $hospital = $query->offset($offset)->limit(3)->get();
      
      if ($hospital->isEmpty()) {
          return response()->json(['html' => '', 'hasMore' => false]);
      }

      $html = view('frontend.partials.hospital_cards', compact('hospital'))->render();
      $hasMore = $query->offset($offset + 3)->exists();

      return response()->json(['html' => $html, 'hasMore' => $hasMore]);
  }

  public function faq()
  {
    return view('frontend.faq');
  }

  public function setcoordinates(Request $request)
  {
    $latitude = $request->query('latitude');
    $longitude = $request->query('longitude');

    session()->put('latitude', $latitude);
    session()->put('longitude', $longitude);

    // Fetch and store visitor details
    $apiKey = 'AIzaSyDDoU-OX0rL-p06QWqGtHq-GdorZ-M-aoY';
    $locationData = $this->googleApi($latitude, $longitude, $apiKey);
    
    UserVisit::create([
        'ip_address' => $request->ip(),
        'latitude' => $latitude,
        'longitude' => $longitude,
        'city' => $locationData['city'] ?? null,
        'state' => $locationData['state'] ?? null,
        'pincode' => $locationData['pincode'] ?? null,
        'area' => $locationData['area'] ?? null,
        'user_agent' => $request->userAgent(),
    ]);

    // Redirect with coordinates as fallback params to avoid session loss issues on live
    return redirect()->route('longitude', [
        'latitude' => $latitude,
        'longitude' => $longitude
    ]);
  }



// public function post(Request $request)
// {
//     set_time_limit(0);
//     $apiKey = 'AIzaSyDDoU-OX0rL-p06QWqGtHq-GdorZ-M-aoY';

//     $latitude = session('latitude');
//     $longitude = session('longitude');

//     if (!$latitude || !$longitude) {
//         return redirect()->route('home')->with('error', 'Please enable location access.');
//     }
    
//     $locationData = $this->getCachedLocationData($latitude, $longitude, $apiKey);
//     $city = $locationData['city'] ?? '';
//     session()->put('city', $city);
    
//     $offset = $request->input('offset', 0);
//     $limit = 3;
//     $radius = (float) $request->input('distance', 1); // Default 5km

//     // Optimized Way: Direct Radial Search using Haversine Formula
//     $hospitalQuery = Hospital::selectRaw("*, 
//         ( 6371 * acos( cos( radians(?) ) *
//           cos( radians( latitude ) )
//           * cos( radians( longitude ) - radians(?)
//           ) + sin( radians(?) ) *
//           sin( radians( latitude ) ) )
//         ) AS distance", [$latitude, $longitude, $latitude])
//         ->where('status', 'active')
//         ->where('emergency', 1);

//     // Apply distance filter
//     $hospitalQuery->having('distance', '<=', $radius);

//     // Apply additional filters (Search bar)
//     if ($search = $request->input('search')) {
//         $hospitalQuery->where(function ($query) use ($search) {
//             $query->where('hospital_name', 'LIKE', "%{$search}%")
//                   ->orWhere('area', 'LIKE', "%{$search}%")
//                   ->orWhere('pincode', 'LIKE', "%{$search}%");
//         });
//     }

//     // Apply feature filters
//     $selectedFeatures = $request->input('feature', []);
//     if ($selectedFeatures) {
//         $hospitalQuery->where(function ($query) use ($selectedFeatures) {
//             foreach ($selectedFeatures as $feature) {
//                 $query->orWhere('features1', $feature)
//                       ->orWhere('features2', $feature)
//                       ->orWhere('features3', $feature)
//                       ->orWhere('features4', $feature);
//             }
//         });
//     }

//     $hospitalQuery->orderBy('distance');

//     // Fetch all qualified hospitals and then handle pagination in-memory to avoid SQL binding errors with complex subqueries
//     $allHospitals = $hospitalQuery->get();
//     $totalCount = $allHospitals->count();
//     $hospitals = $allHospitals->slice($offset, $limit);

//     $features = $this->getCachedHospitalFeatures();

//     if ($request->ajax()) {
//         if ($hospitals->isEmpty()) {
//             return response()->json(['html' => '', 'hasMore' => false]);
//         }
//         $html = view('frontend.partials.emergency_cards', ['hospital' => $hospitals])->render();
//         $hasMore = ($offset + $limit) < $totalCount;
//         return response()->json(['html' => $html, 'hasMore' => $hasMore]);
//     }

//     return view('frontend.emergency', [
//         'hospital' => $hospitals,
//         'features' => $features,
//     ]);
// }

/*
==========================================================================
BACKUP: ORIGINAL SLOW IMPLEMENTATION (Multiple Google Geocoding calls)
========================================================================== */
public function post(Request $request)
{
    set_time_limit(0);
    $apiKey = 'AIzaSyDDoU-OX0rL-p06QWqGtHq-GdorZ-M-aoY';

    // Retrieve from request first (reliable on live), then fallback to session
    $latitude = $request->latitude ?: session('latitude');
    $longitude = $request->longitude ?: session('longitude');

    if (!$latitude || !$longitude) {
        if ($request->ajax()) {
            return response()->json(['error' => 'Location missing'], 400);
        }
        return redirect()->route('home')->with('error', 'Please enable location access.');
    }

    // Fetch city and pincode using Geocoding API (Cached to reduce repetitive calls)
    $locationData = $this->getCachedLocationData($latitude, $longitude, $apiKey);
    $city = $locationData['city'] ?? '';
    $pincode = $locationData['pincode'] ?? '';

    session()->put('city', $city);
    
    $offset = (int) $request->input('offset', 0);
    $limit = 3;
    $radius = (float) $request->input('distance', 2) * 1000;

    // Fetch nearby hospitals using Places API with pagetoken support (cached results)
    $allResults = $this->getCachedNearbyHospitals($latitude, $longitude, $radius, $apiKey);

    // Extract and map locations from the API response (Solves API N+1 Issue)
    $locations = $this->mapHospitalLocations($allResults, $apiKey);
    
    // Build the query for hospitals with Eager Loading (Solves DB N+1 Issue)
    $hospitalQuery = Hospital::with('contacts')->where('emergency', 1)
                              ->where('status', 'active');

    if ($search = $request->input('search')) {
        $hospitalQuery->where(function ($query) use ($search) {
            $query->where('hospital_name', 'LIKE', "%{$search}%")
                  ->orWhere('area', 'LIKE', "%{$search}%")
                  ->orWhere('pincode', 'LIKE', "%{$search}%");
        });
    }

    if (!empty($locations)) {
        $pincodes = array_column($locations, 'pincode');
        $hospitalQuery->whereIn('pincode', $pincodes);
    } else {
        // Fallback: If Google finds nothing, filter by current city & pincode
        $hospitalQuery->where(function ($q) use ($city, $pincode) {
            $q->where('city', 'LIKE', "%{$city}%")
              ->orWhere('pincode', 'LIKE', "%{$pincode}%");
        });
    }

    $selectedFeatures = $request->input('feature', []);
    if ($selectedFeatures) {
        $hospitalQuery->where(function ($query) use ($selectedFeatures) {
            foreach ($selectedFeatures as $feature) {
                $query->orWhere('features1', $feature)
                      ->orWhere('features2', $feature)
                      ->orWhere('features3', $feature)
                      ->orWhere('features4', $feature);
            }
        });
    }

    // Get total count for pagination
    $totalCount = $hospitalQuery->count();

    // Get paginated results
    $hospitals = $hospitalQuery->offset($offset)->limit($limit)->get();

    // Fetch unique features (Cached to reduce repetitive calls)
    $features = $this->getCachedHospitalFeatures();

    // AJAX response for "Load More"
    if ($request->ajax()) {
        if ($hospitals->isEmpty()) {
            return response()->json(['html' => '', 'hasMore' => false]);
        }
        $html = view('frontend.partials.emergency_cards', ['hospital' => $hospitals])->render();
        $hasMore = ($offset + $limit) < $totalCount;
        return response()->json(['html' => $html, 'hasMore' => $hasMore]);
    }

    return view('frontend.emergency', [
        'hospital' => $hospitals,
        'features' => $features,
    ]);
}


private function getCachedLocationData($latitude, $longitude, $apiKey)
{
    $locationKey = "{$latitude},{$longitude}";
    return Cache::remember($locationKey, 86400, function () use ($latitude, $longitude, $apiKey) {
        return $this->googleApi($latitude, $longitude, $apiKey);
    });
}

private function getCachedNearbyHospitals($latitude, $longitude, $radius, $apiKey)
{
    $cacheKey = "nearby_hospitals_{$latitude}_{$longitude}_{$radius}";
    return Cache::remember($cacheKey, 86400, function () use ($latitude, $longitude, $radius, $apiKey) {
        $results = [];
        $pageToken = null;

        do {
            $params = [
                'location' => "{$latitude},{$longitude}",
                'radius' => $radius,
                'type' => 'hospital',
                'key' => $apiKey,
            ];

            if ($pageToken) {
                $params['pagetoken'] = $pageToken;
                sleep(2); // Pause between pagetoken requests as recommended
            }

            $response = Http::get('https://maps.googleapis.com/maps/api/place/nearbysearch/json', $params);
            $data = $response->json();

            if (!empty($data['results'])) {
                $results = array_merge($results, $data['results']);
            }

            $pageToken = $data['next_page_token'] ?? null;
        } while ($pageToken);

        return $results;
    });
}

private function mapHospitalLocations(array $hospitals, $apiKey)
{
    // Step 1: Identify which locations are not already cached
    $missingIndexes = [];
    foreach ($hospitals as $index => $hospital) {
        $lat = $hospital['geometry']['location']['lat'];
        $lng = $hospital['geometry']['location']['lng'];
        if (!Cache::has("hospital_location_{$lat}_{$lng}")) {
            $missingIndexes[$index] = $hospital;
        }
    }

    // Step 2: Fetch all missing locations in parallel (Solves API N+1 Issue)
    if (!empty($missingIndexes)) {
        $responses = Http::pool(function (Pool $pool) use ($missingIndexes, $apiKey) {
            foreach ($missingIndexes as $index => $hospital) {
                $lat = $hospital['geometry']['location']['lat'];
                $lng = $hospital['geometry']['location']['lng'];
                $pool->as("h_$index")->get('https://maps.googleapis.com/maps/api/geocode/json', [
                    'latlng' => "{$lat},{$lng}",
                    'key' => $apiKey,
                ]);
            }
        });

        // Step 3: Process and Cache Parallel Responses
        foreach ($missingIndexes as $index => $hospital) {
            $response = $responses["h_$index"] ?? null;
            if ($response && $response->successful()) {
                $data = $response->json();
                $state = $this->parseAddressComponents($data);
                
                $lat = $hospital['geometry']['location']['lat'];
                $lng = $hospital['geometry']['location']['lng'];
                
                Cache::put("hospital_location_{$lat}_{$lng}", [
                    'name' => $hospital['name'],
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'vicinity' => $hospital['vicinity'],
                    'city' => $state['city'],
                    'pincode' => $state['pincode'],
                ], 86400);
            }
        }
    }

    // Step 4: Map all results from Cache
    return array_map(function ($hospital) {
        $lat = $hospital['geometry']['location']['lat'];
        $lng = $hospital['geometry']['location']['lng'];
        return Cache::get("hospital_location_{$lat}_{$lng}");
    }, $hospitals);
}

/**
 * Helper to parse Google Geocode address components
 */
private function parseAddressComponents($data)
{
    $city = $state = $pincode = $area = null;
    foreach ($data['results'][0]['address_components'] ?? [] as $component) {
        if (in_array('locality', $component['types'])) $city = $component['long_name'];
        if (in_array('administrative_area_level_1', $component['types'])) $state = $component['long_name'];
        if (in_array('postal_code', $component['types'])) $pincode = $component['long_name'];
        if (in_array('sublocality', $component['types']) || in_array('neighborhood', $component['types'])) $area = $component['long_name'];
    }
    return compact('city', 'state', 'pincode', 'area');
}

private function getCachedHospitalFeatures()
{
    return Cache::remember('hospital_features', 86400, function () {
        return Hospital::where('emergency', 1)
            ->select('features1', 'features2', 'features3', 'features4')
            ->distinct()
            ->get()
            ->flatMap(function ($hospital) {
                return array_filter([$hospital->features1, $hospital->features2, $hospital->features3, $hospital->features4]);
            })
            ->unique()
            ->values()
            ->toArray();
    });
}

private function googleApi($latitude, $longitude, $apiKey)
{
    $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
        'latlng' => "{$latitude},{$longitude}",
        'key' => $apiKey,
    ]);

    $data = $response->json();

    $city = null;
    $state = null;
    $pincode = null;
    $area = null;
    foreach ($data['results'][0]['address_components'] ?? [] as $component) {
        if (in_array('locality', $component['types'])) {
            $city = $component['long_name'];
        }
        if (in_array('administrative_area_level_1', $component['types'])) {
            $state = $component['long_name'];
        }
        if (in_array('postal_code', $component['types'])) {
            $pincode = $component['long_name'];
        }
        if (in_array('sublocality', $component['types']) || in_array('neighborhood', $component['types'])) {
            $area = $component['long_name'];
        }
    }

    return compact('city', 'state', 'pincode', 'area');
}

  public function aboutus()
  {
    return view('frontend.aboutus');
  }

  public function contactus()
  {
    return view('frontend.contactus');
  }

  public function services()
  {
    return view('frontend.services');
  }
  public function terms()
  {
    return view('frontend.terms');
  }

  public function privacyPolicy()
  {
    return view('frontend.privacy');
  }

  // public function call(Request $request)
  // {

  //   $request->validate([
  //     'hospital_id' => "required",
  //     'patient_name' => 'required|string|max:255',
  //     'contact' => 'required|digits_between:10,15|numeric'
  //   ]);
  //   $hospital = Hospital::with('contacts')->where('id', $request->hospital_id)->first();
  //   // dd($hospital);
  //   $api_key = '9ecda612ebfeb89f36a712e6c39b769075e739004bb18092';
  //   $api_token = '3a2d575d67a561f0ffe8aa5e62e5f9aecf8117adb5009a7e';
  //   $account_sid = 'uc1641'; // Exotel Account SID
  //   try {
  //     $contacts = $hospital->contacts->pluck('contact')->toArray();
      
  //     // Use both individual contact field and extra contacts
  //     $allContacts = array_values(array_unique(array_filter(array_merge($contacts))));
  //     // dd($allContacts);
  //     $toString = implode(',', $allContacts);

  //     $formParams = [
  //       'From' => $request->contact,
  //       'To' => $toString,
  //       'CallerId' => '02048556108',
  //       'Record'=> 'true',
  //       'RecordingChannels'=>'single',
  //       'RecordingFormat'=>'mp3',
  //       'StatusCallback' => route('exotel.callback'),
  //     ];

  //     $response = $this->client->post("$account_sid/Calls/connect.json", [
  //       'auth' => [$api_key, $api_token],
  //       'form_params' => $formParams,
  //     ]);

  //     $data = json_decode($response->getBody(), true);

  //     if (isset($data['Call'])) {

  //       $sid = $data['Call']['Sid'] ?? null;
  //       $from = $data['Call']['From'] ?? null;
  //       $to = $data['Call']['To'] ?? null;

  //       DB::table('enquiries')->insert([
  //         'patient_name' => $request->patient_name,
  //         'hospital_id' => $hospital->id,
  //         'sid' => $sid,
  //         'from' => $from,
  //         'to' => $to,
  //         'status' => 'pending',
  //         'created_at' => now(),
  //         'updated_at' => now(),
  //       ]);
       
  //     } else {
  //       return back()->with('error', 'Failed to initiate call.');
  //     }
      
  //     return back()->with('success', 'Call initiated successfully!');
  //   } catch (RequestException $e) {
  //     $response = $e->getResponse();
  //     $responseBodyAsString = $response ? $response->getBody()->getContents() : $e->getMessage();
  //     return back()->with('error',  'Error: ' . $responseBodyAsString);
  //   }
  // }

  // public function handleCallStatus(Request $request)
  // {
  //     // Log the callback for debugging
  //     Log::channel('sms')->info('Exotel Call Status Callback:', $request->all());

  //     $callStatus = $request->input('Status'); 
  //     $patientContact = $request->input('From');
  //     $answeredBy = $request->input('DialWhomNumber') ?? $request->input('To'); // The number that actually received/answered the call
      
  //     // Exotel status 'completed' indicates the call was successful and finished
  //     if ($callStatus === 'completed' && !empty($answeredBy)) {
          
  //         $api_key = '9ecda612ebfeb89f36a712e6c39b769075e739004bb18092';
  //         $api_token = '3a2d575d67a561f0ffe8aa5e62e5f9aecf8117adb5009a7e';
  //         $account_sid = 'uc1641';

  //         try {
  //             $callSid = $request->input('CallSid');
  //             $enquiry = DB::table('enquiries')->where('sid', $callSid)->first();
              
  //             if (!$enquiry) {
  //                 Log::channel('sms')->warning("No enquiry found for CallSid: $callSid");
  //                 return response()->json(['status' => 'enquiry_not_found']);
  //             }

  //             $patientName = $enquiry->patient_name;
  //             $patientContact = $enquiry->from;
  //             $hospital = Hospital::find($enquiry->hospital_id);
  //             $hospitalName = $hospital ? $hospital->hospital_name : 'Hospital';
  //             $helpline = '8149801662';

  //             $cleanAnsweredBy = ltrim($answeredBy, '0');
  //             if (strlen($cleanAnsweredBy) === 10) {
  //                 $cleanAnsweredBy = '91' . $cleanAnsweredBy;
  //             }
              
  //             // Only send SMS if it was answered by a valid number
  //             $this->client->post("$account_sid/Sms/send.json", [
  //                 'auth' => [$api_key, $api_token],
  //                 'form_params' => [
  //                     'From' => "URGKER",
  //                     'To' =>  $cleanAnsweredBy,
  //                     'Body' => "You just spoke with {$patientName} {$patientContact} for {$hospitalName} ambulance help. For more assistance call Team Urge Care {$helpline}",
  //                     'DltTemplateId' => '1707177364516989149',
  //                     'DltEntityId' => '1701164398108412688', 
  //                     'SmsType' => 'PROMOTIONAL',
  //                 ],
  //             ]);
  //             Log::channel('sms')->info("Failover SMS sent successfully to responder: $answeredBy");
  //         } catch (\Exception $e) {
  //             Log::channel('sms')->error("Exotel Callback Error: " . $e->getMessage());
  //         }
  //     } else {
  //         // MISSES CALL FALLBACK
  //         try {
  //             $callSid = $request->input('CallSid');
  //             $enquiry = DB::table('enquiries')->where('sid', $callSid)->first();
              
  //             if ($enquiry) {
  //                 $api_key = '9ecda612ebfeb89f36a712e6c39b769075e739004bb18092';
  //                 $api_token = '3a2d575d67a561f0ffe8aa5e62e5f9aecf8117adb5009a7e';
  //                 $account_sid = 'uc1641';
                  
  //                 $patientName = $enquiry->patient_name;
  //                 $patientContact = $enquiry->from;
  //                 $hospital = Hospital::find($enquiry->hospital_id);
  //                 $hospitalName = $hospital ? $hospital->hospital_name : 'Hospital';
                  
  //                 // Send Missed Call SMS to Fallback Number 7888021021 (Same body as answered call)
  //                 $this->client->post("$account_sid/Sms/send.json", [
  //                     'auth' => [$api_key, $api_token],
  //                     'form_params' => [
  //                         'From' => "URGKER",
  //                         'To' =>  '917888021021',
  //                         'Body' => "You just spoke with {$patientName} {$patientContact} for {$hospitalName} ambulance help. For more assistance call Team Urge Care 8149801662",
  //                         'DltTemplateId' => '1707177364516989149',
  //                         'DltEntityId' => '1701164398108412688', 
  //                         'SmsType' => 'PROMOTIONAL',
  //                     ],
  //                 ]);
  //                 Log::channel('sms')->info("Missed Call Alert sent to 7888021021 for CallSid: $callSid");
  //             }
  //         } catch (\Exception $e) {
  //             Log::channel('sms')->error("Exotel Missed Call Error: " . $e->getMessage());
  //         }
  //     }

  //     return response()->json(['status' => 'ok']);
  // }

    public function call(Request $request, ExotelService $exotel)
    {
        $request->validate([
            'hospital_id' => "required",
            'patient_name' => 'required|string|max:255',
            'contact' => 'required|digits_between:10,15|numeric'
        ]);
        $hospital = Hospital::with(['contacts' => fn ($q) => $q->orderBy('id')])->findOrFail($request->hospital_id);

        $contacts = $hospital->contacts->pluck('contact')->toArray();
        $numbers = array_values(array_unique(array_filter($contacts)));
        if (empty($numbers)) {
            return back()->with('error', 'No contact numbers found');
        }

        try {
            $callLog = $exotel->createLogAndStartDial(
                (string) $request->contact,
                $numbers,
                $request->patient_name,
                (int) $hospital->id
            );
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Call started successfully!']);
        }

        return back()->with('success', 'Call started...');
    }

  public function urgecare()
  {
    return view('frontend.urgecare');
  }

  public function partner()
  {
    return view('frontend.partner');
  }

  public function nonEmergency(Request $request)
  {
    $hospital = Hospital::where('emergency', 1)->where('status', 'active');
    if ($request->search) {
      $search = $request->search;
      $hospital->where(function ($query) use ($search) {
        $query->where('hospital_name', 'LIKE', "%{$search}%")
          
           ->orWhere('area', 'LIKE', "%{$search}%")
          ->orWhere('pincode', 'LIKE', "%{$search}%");
      });
    }


    $hospital = $hospital->limit(3)->get();
    return view('frontend.nonemergency', compact('hospital'));
  }
}

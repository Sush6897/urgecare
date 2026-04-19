<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\UserVisit;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FrontendController extends Controller
{

  protected $client;

  public function __construct()
  {
    $this->client = new Client([
      'base_uri' => 'https://api.exotel.com/v1/Accounts/', // Exotel API base URL
    ]);
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

    // Redirect to the desired route or back to the previous page
    return redirect()->route('longitude');
  }



public function post(Request $request)
{
    set_time_limit(0);
    $apiKey = 'AIzaSyDDoU-OX0rL-p06QWqGtHq-GdorZ-M-aoY';

    $latitude = session('latitude');
    $longitude = session('longitude');
    
    $locationData = $this->getCachedLocationData($latitude, $longitude, $apiKey);
    $city = $locationData['city'];
    $pincode = $locationData['pincode'];

    session()->put('city', $city);
    
    $offset = $request->input('offset', 0);
    $limit = 3;

    // Step 1: Discover nearby hospitals using Google Places API (1 call only)
    $radius = $request->input('distance', 1) * 1000;
    $cacheKey = "google_nearby_hybrid_{$latitude}_{$longitude}_{$radius}";
    
    $googleResults = Cache::remember($cacheKey, 3600, function () use ($latitude, $longitude, $radius, $apiKey) {
        $response = Http::get('https://maps.googleapis.com/maps/api/place/nearbysearch/json', [
            'location' => "{$latitude},{$longitude}",
            'radius' => $radius,
            'type' => 'hospital',
            'key' => $apiKey,
        ]);
        return $response->json()['results'] ?? [];
    });

    // Step 2: Use names from Google to query our indexed local database
    $hospitalNames = array_column($googleResults, 'name');
    
    $hospitalQuery = Hospital::where('status', 'active')
                              ->where('emergency', 1);

    if (!empty($hospitalNames)) {
        $hospitalQuery->where(function ($q) use ($hospitalNames) {
            foreach ($hospitalNames as $name) {
                $q->orWhere('hospital_name', 'LIKE', "%{$name}%");
            }
        });
    }

    // Step 3: Apply additional filters (Search bar, Sidebar Features)
    if ($search = $request->input('search')) {
        $hospitalQuery->where(function ($query) use ($search) {
            $query->where('hospital_name', 'LIKE', "%{$search}%")
                  ->orWhere('area', 'LIKE', "%{$search}%")
                  ->orWhere('pincode', 'LIKE', "%{$search}%");
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

    // Clone for counting
    $countQuery = clone $hospitalQuery;

    $hospitals = $hospitalQuery->offset($offset)->limit($limit)->get();
    $features = $this->getCachedHospitalFeatures();

    if ($request->ajax()) {
        if ($hospitals->isEmpty()) {
            return response()->json(['html' => '', 'hasMore' => false]);
        }
        $html = view('frontend.partials.emergency_cards', ['hospital' => $hospitals])->render();
        // Fixed: Added limit(1) because offset needs a limit in some MariaDB/MySQL versions
        $hasMore = $countQuery->offset($offset + $limit)->limit(1)->exists();
        return response()->json(['html' => $html, 'hasMore' => $hasMore]);
    }

    return view('frontend.emergency', [
        'hospital' => $hospitals,
        'features' => $features,
    ]);
}

/*
==========================================================================
BACKUP: ORIGINAL SLOW IMPLEMENTATION (Multiple Google Geocoding calls)
========================================================================== */
// public function post(Request $request)
// {
//     set_time_limit(0);
//     $apiKey = 'AIzaSyDDoU-OX0rL-p06QWqGtHq-GdorZ-M-aoY';

//     // Retrieve latitude and longitude from session
//     $latitude = session('latitude');
//     $longitude = session('longitude');

//     // Fetch city and pincode using Geocoding API (Cached to reduce repetitive calls)
//     $locationData = $this->getCachedLocationData($latitude, $longitude, $apiKey);
//     $city = $locationData['city'];
//     $pincode = $locationData['pincode'];

//     session()->put('city', $city);

//     $radius = $request->input('distance', 1) * 1000; // Default radius 2000 meters

//     // Fetch nearby hospitals using Places API with pagetoken support (cached results)
//     $allResults = $this->getCachedNearbyHospitals($latitude, $longitude, $radius, $apiKey);

//     // Extract and map locations from the API response
//     $locations = $this->mapHospitalLocations($allResults, $apiKey);

//     // Build the query for hospitals
//     $hospitalQuery = Hospital::where('emergency', 1)
//                               ->where('status', 'active');

//     if ($search = $request->input('search')) {
//         $hospitalQuery->where(function ($query) use ($search) {
//             $query->where('hospital_name', 'LIKE', "%{$search}%")
//                   ->orWhere('area', 'LIKE', "%{$search}%")
//                   ->orWhere('pincode', 'LIKE', "%{$search}%");
//         });
//     }

//     if (!empty($locations)) {
//         $pincodes = array_column($locations, 'pincode');
//         $hospitalQuery->whereIn('pincode', $pincodes);
//     }

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

//     $hospitals = $hospitalQuery->get();

//     // Fetch unique features (Cached to reduce repetitive calls)
//     $features = $this->getCachedHospitalFeatures();

//     return view('frontend.emergency', [
//         'hospital' => $hospitals,
//         'features' => $features,
//     ]);
// }


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
    return array_map(function ($hospital) use ($apiKey) {
        $lat = $hospital['geometry']['location']['lat'];
        $lng = $hospital['geometry']['location']['lng'];

        return Cache::remember("hospital_location_{$lat}_{$lng}", 86400, function () use ($lat, $lng, $hospital, $apiKey) {
            $state = $this->googleApi($lat, $lng, $apiKey);
            return [
                'name' => $hospital['name'],
                'latitude' => $lat,
                'longitude' => $lng,
                'vicinity' => $hospital['vicinity'],
                'city' => $state['city'],
                'pincode' => $state['pincode'],
            ];
        });
    }, $hospitals);
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

  public function call(Request $request)
  {

    $request->validate([
      'hospital_id' => "required",
      'patient_name' => 'required|string|max:255',
      'contact' => 'required|digits_between:10,15| numeric'
    ]);
    $hospital = Hospital::with('contacts')->where('id', $request->hospital_id)->first();
    // dd($hospital);
    $api_key = '9ecda612ebfeb89f36a712e6c39b769075e739004bb18092';
    $api_token = '3a2d575d67a561f0ffe8aa5e62e5f9aecf8117adb5009a7e';
    $account_sid = 'uc1641'; // Exotel Account SID
    try {
      $contacts = $hospital->contacts->pluck('contact')->toArray();
      
      // Use both individual contact field and extra contacts
      $allContacts = array_unique(array_filter(array_merge([$hospital->contact], $contacts)));
      $toString = implode(',', $allContacts);

      $formParams = [
        'From' => $request->contact,
        'To' => $toString,
        'CallerId' => '02048556108',
        'Record'=> 'true',
        'RecordingChannels'=>'single',
        'RecordingFormat'=>'mp3',
        'StatusCallback' => route('exotel.callback'),
      ];

      $response = $this->client->post("$account_sid/Calls/connect.json", [
        'auth' => [$api_key, $api_token],
        'form_params' => $formParams,
      ]);

      $data = json_decode($response->getBody(), true);

      if (isset($data['Call'])) {

        $sid = $data['Call']['Sid'] ?? null;
        $from = $data['Call']['From'] ?? null;
        $to = $data['Call']['To'] ?? null;

        DB::table('enquiries')->insert([
          'patient_name' => $request->patient_name,
          'hospital_id' => $hospital->id,
          'sid' => $sid,
          'from' => $from,
          'to' => $to,
          'status' => 'pending',
          'created_at' => now(),
          'updated_at' => now(),
        ]);
       
      } else {
        return back()->with('error', 'Failed to initiate call.');
      }
      
      return back()->with('success', 'Call initiated successfully!');
    } catch (RequestException $e) {
      $response = $e->getResponse();
      $responseBodyAsString = $response ? $response->getBody()->getContents() : $e->getMessage();
      return back()->with('error',  'Error: ' . $responseBodyAsString);
    }
  }

  public function handleCallStatus(Request $request)
  {
      // Log the callback for debugging
      Log::channel('sms')->info('Exotel Call Status Callback:', $request->all());

      $callStatus = $request->input('Status'); 
      $patientContact = $request->input('From');
      $answeredBy = $request->input('DialWhomNumber') ?? $request->input('To'); // The number that actually received/answered the call
      
      // Exotel status 'completed' indicates the call was successful and finished
      if ($callStatus === 'completed' && !empty($answeredBy)) {
          
          $api_key = '9ecda612ebfeb89f36a712e6c39b769075e739004bb18092';
          $api_token = '3a2d575d67a561f0ffe8aa5e62e5f9aecf8117adb5009a7e';
          $account_sid = 'uc1641';

          try {
              $callSid = $request->input('CallSid');
              $enquiry = DB::table('enquiries')->where('sid', $callSid)->first();
              
              if (!$enquiry) {
                  Log::channel('sms')->warning("No enquiry found for CallSid: $callSid");
                  return response()->json(['status' => 'enquiry_not_found']);
              }

              $patientName = $enquiry->patient_name;
              $patientContact = $enquiry->from;
              $hospital = Hospital::find($enquiry->hospital_id);
              $hospitalName = $hospital ? $hospital->hospital_name : 'Hospital';
              $helpline = '8149801662';

              $cleanAnsweredBy = ltrim($answeredBy, '0');
              if (strlen($cleanAnsweredBy) === 10) {
                  $cleanAnsweredBy = '91' . $cleanAnsweredBy;
              }
              
              // Only send SMS if it was answered by a valid number
              $this->client->post("$account_sid/Sms/send.json", [
                  'auth' => [$api_key, $api_token],
                  'form_params' => [
                      'From' => "URGKER",
                      'To' =>  $cleanAnsweredBy,
                      'Body' => "You just spoke with {$patientName} {$patientContact} for {$hospitalName} ambulance help. For more assistance call Team Urge Care {$helpline}",
                      'DltTemplateId' => '1707177364516989149',
                      'DltEntityId' => '1701164398108412688', 
                      'SmsType' => 'PROMOTIONAL',
                  ],
              ]);
              Log::channel('sms')->info("Failover SMS sent successfully to responder: $answeredBy");
          } catch (\Exception $e) {
              Log::channel('sms')->error("Exotel Callback Error: " . $e->getMessage());
          }
      } else {
          // MISSES CALL FALLBACK
          try {
              $callSid = $request->input('CallSid');
              $enquiry = DB::table('enquiries')->where('sid', $callSid)->first();
              
              if ($enquiry) {
                  $api_key = '9ecda612ebfeb89f36a712e6c39b769075e739004bb18092';
                  $api_token = '3a2d575d67a561f0ffe8aa5e62e5f9aecf8117adb5009a7e';
                  $account_sid = 'uc1641';
                  
                  $patientName = $enquiry->patient_name;
                  $patientContact = $enquiry->from;
                  $hospital = Hospital::find($enquiry->hospital_id);
                  $hospitalName = $hospital ? $hospital->hospital_name : 'Hospital';
                  
                  // Send Missed Call SMS to Fallback Number 7888021021 (Same body as answered call)
                  $this->client->post("$account_sid/Sms/send.json", [
                      'auth' => [$api_key, $api_token],
                      'form_params' => [
                          'From' => "URGKER",
                          'To' =>  '917888021021',
                          'Body' => "You just spoke with {$patientName} {$patientContact} for {$hospitalName} ambulance help. For more assistance call Team Urge Care 8149801662",
                          'DltTemplateId' => '1707177364516989149',
                          'DltEntityId' => '1701164398108412688', 
                          'SmsType' => 'PROMOTIONAL',
                      ],
                  ]);
                  Log::channel('sms')->info("Missed Call Alert sent to 7888021021 for CallSid: $callSid");
              }
          } catch (\Exception $e) {
              Log::channel('sms')->error("Exotel Missed Call Error: " . $e->getMessage());
          }
      }

      return response()->json(['status' => 'ok']);
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

<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;
use App\Rules\AtLeastThreeFeatures;
use Dotenv\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Support\Facades\Hash;

class HospitalController extends Controller
{
    //

    public function index() {
        $hospitals = Hospital::all();

    // Pass the data to the view
    return view('backend.hospital.index', compact('hospitals'));
    }
    public function create()
    {
        return view('backend.hospital.create');
    }
   public function store(Request $request)
    {
        $validatedData = $request->validate([
            'hospital_name' => 'required|string|max:255',
            'email' => 'required|email|unique:hospitals,email',
            'password' => 'required|string|min:8|confirmed',

            'address' => 'required|string',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'pincode' => 'required|string|max:255',
            'area' => 'required|string|max:255',

            // NEW contacts validation
            'contacts' => 'required|array|min:1',
            'contacts.*' => 'required|string|max:20',

            'features.features1' => ['nullable', 'string', 'max:255'],
            'features.features2' => ['nullable', 'string', 'max:255'],
            'features.features3' => ['nullable', 'string', 'max:255'],
            'features.features4' => ['nullable', 'string', 'max:255'],
            'features' => ['nullable', new AtLeastThreeFeatures()],

            'gmap' => 'required|url',
            'longitude' => 'required|string|max:255',
            'latitude' => 'required|string|max:255',

            'status' => 'required|in:active,inactive',

            'type' => 'required|array',
            'type.*' => 'in:emergency,non-emergency',
        ], [

            'features.features1.string' => 'Feature 1 must be a string.',
            'features.features1.max' => 'Feature 1 may not be greater than 255 characters.',

            'features.features2.string' => 'Feature 2 must be a string.',
            'features.features2.max' => 'Feature 2 may not be greater than 255 characters.',

            'features.features3.string' => 'Feature 3 must be a string.',
            'features.features3.max' => 'Feature 3 may not be greater than 255 characters.',

            'features.features4.string' => 'Feature 4 must be a string.',
            'features.features4.max' => 'Feature 4 may not be greater than 255 characters.',

            'features' => 'At least three features are required.',
        ]);


        $emergency = in_array('emergency', $request->type) ? 1 : 0;
        $nonemergency = in_array('non-emergency', $request->type) ? 1 : 0;


        $hospital = Hospital::create([
            'hospital_name' => $validatedData['hospital_name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),

            'address' => $validatedData['address'],
            'country' => $validatedData['country'],
            'state' => $validatedData['state'],
            'area' => $validatedData['area'],
            'city' => $validatedData['city'],
            'pincode' => $validatedData['pincode'],

            'features1' => $validatedData['features']['features1'] ?? null,
            'features2' => $validatedData['features']['features2'] ?? null,
            'features3' => $validatedData['features']['features3'] ?? null,
            'features4' => $validatedData['features']['features4'] ?? null,

            'gmap' => $validatedData['gmap'],
            'longitude' => $validatedData['longitude'],
            'latitude' => $validatedData['latitude'],

            'status' => $validatedData['status'],

            'emergency' => $emergency,
            'nonemergency' => $nonemergency,
        ]);


        // 🔹 Insert contacts into hospital_contacts table
        foreach ($validatedData['contacts'] as $contact) {

            if (!empty($contact)) {

                $hospital->contacts()->create([
                    'contact' => $contact
                ]);
            }
        }


        return redirect()->route('hospital.index')
            ->with('success', 'Hospital created successfully.');
    }
    public function edit($id)
    {
        // Find hospital with contacts
        $hospital = Hospital::with('contacts')->findOrFail($id);

        return view('backend.hospital.edit', compact('hospital'));
    }
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'hospital_name' => 'required|string|max:255',
            'email' => 'required|email|unique:hospitals,email,'.$id,
            'password' => 'nullable|string|min:8|confirmed',

            'address' => 'required|string',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'pincode' => 'required|string|max:255',
            'area' => 'required|string|max:255',

            // NEW contacts validation
            'contacts' => 'required|array|min:1',
            'contacts.*' => 'required|string|max:20',

            'features.features1' => ['nullable', 'string', 'max:255'],
            'features.features2' => ['nullable', 'string', 'max:255'],
            'features.features3' => ['nullable', 'string', 'max:255'],
            'features.features4' => ['nullable', 'string', 'max:255'],
            'features' => ['nullable', new AtLeastThreeFeatures()],

            'gmap' => 'required|url',
            'longitude' => 'required|string|max:255',
            'latitude' => 'required|string|max:255',

            'status' => 'required|in:active,inactive',
            'type' => 'required|array',
            'type.*' => 'in:emergency,non-emergency',
        ]);

        // Find hospital
        $hospital = Hospital::findOrFail($id);

        // Set flags
        $emergency = in_array('emergency', $request->type) ? 1 : 0;
        $nonemergency = in_array('non-emergency', $request->type) ? 1 : 0;

        // Update hospital
        $updateData = [
            'hospital_name' => $validatedData['hospital_name'],
            'email' => $validatedData['email'],

            'address' => $validatedData['address'],
            'country' => $validatedData['country'],
            'state' => $validatedData['state'],
            'city' => $validatedData['city'],
            'area' => $validatedData['area'],
            'pincode' => $validatedData['pincode'],

            'features1' => $validatedData['features']['features1'] ?? null,
            'features2' => $validatedData['features']['features2'] ?? null,
            'features3' => $validatedData['features']['features3'] ?? null,
            'features4' => $validatedData['features']['features4'] ?? null,

            'gmap' => $validatedData['gmap'],
            'longitude' => $validatedData['longitude'],
            'latitude' => $validatedData['latitude'],

            'status' => $validatedData['status'],
            'emergency' => $emergency,
            'nonemergency' => $nonemergency,
        ];

        if (!empty($validatedData['password'])) {
            $updateData['password'] = Hash::make($validatedData['password']);
        }

        $hospital->update($updateData);

        // 🔹 Update contacts

        // delete old contacts
        $hospital->contacts()->delete();

        // insert new contacts
        foreach ($validatedData['contacts'] as $contact) {

            if (!empty($contact)) {

                $hospital->contacts()->create([
                    'contact' => $contact
                ]);
            }
        }

        return redirect()->route('hospital.index')
            ->with('success', 'Hospital updated successfully.');
    }

   public function destroy($id)
    {
        $hospital = Hospital::findOrFail($id);

        if ($hospital->enquiries()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete hospital with existing enquiries.');
        }

        $hospital->delete();

        return redirect()->route('hospital.index')
            ->with('success', 'Hospital moved to trash successfully.');
    }

   public function trash()
    {
        $hospitals = Hospital::onlyTrashed()
            ->with('contacts')
            ->get();

        return view('backend.hospital.trash', compact('hospitals'));
    }

    public function restore($id)
    {
        $hospital = Hospital::onlyTrashed()->findOrFail($id);
        $hospital->restore();

        return redirect()->route('hospital.trash')->with('success', 'Hospital restored successfully.');
    }
    
    public function fetchCoordinates(Request $request)
    {
        $url = $request->gmap;
        $pattern = '/@([-0-9.]+),([-0-9.]+)/';

        if (preg_match($pattern, $url, $matches)) {
         
            $apiKey = 'AIzaSyDDoU-OX0rL-p06QWqGtHq-GdorZ-M-aoY'; // Get API key from config/services.php or .env file
            $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$matches[1]},{$matches[2]}&key={$apiKey}";
        
            $response = Http::get($url);
        
            if ($response->successful()) {
                $data = $response->json();
            
                if (isset($data['results'])) {
                  
                    $addressComponents = $data['results'][0]['address_components'];
                    // dd( $addressComponents);
                    $locationDetails = [
                        'country' => null,
                        'state' => null,
                        'city' => null,
                        'pincode' => null,
                    ];
                  
                    foreach ($addressComponents as $component) {
                        if (in_array('country', $component['types'])) {
                            $locationDetails['country'] = $component['long_name'];
                        }
                        if (in_array('administrative_area_level_1', $component['types'])) {
                            $locationDetails['state'] = $component['long_name'];
                        }
                       
                        if (in_array('postal_code', $component['types'])) {
                            $locationDetails['pincode'] = $component['long_name'];
                        }
                        
                        if (in_array('locality', $component['types'])) {
                            $locationDetails['city'] = $component['long_name'];
                       
                        }
                    }
                    $locationDetails['latitude']=$matches[1];
                    $locationDetails['longitude']=$matches[2];
                    
                    return response()->json($locationDetails);
                }
            }
            
        } else {
            // Attempt to extract place ID
            $placeId = $this->extractPlaceIdFromUrl($url);
            if ($placeId) {
                // Coordinates found in the URL

                return  $this->getCoordinatesUsingPlaceId($placeId);
            }

            // If no coordinates or place ID, use the Geocoding API
            return  $this->getCoordinatesUsingGeocodingAPI($url);
        }
    }

    function extractPlaceIdFromUrl($url)
    {
        // Regex to match place ID in the URL
        $pattern = '/place\/([^\/\?]+)/';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        return null;
    }

    function getCoordinatesUsingPlaceId($placeId)
    {
        $apiKey = 'AIzaSyDDoU-OX0rL-p06QWqGtHq-GdorZ-M-aoY';
        $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
            'place_id' => $placeId,
            'key' => $apiKey,
        ]);

        $data = $response->json();

        if (isset($data['result']['geometry']['location'])) {
            return [
                'latitude' => $data['result']['geometry']['location']['lat'],
                'longitude' => $data['result']['geometry']['location']['lng'],
            ];
        }

        return null;
    }

    function getCoordinatesUsingGeocodingAPI($url)
    {
        $apiKey = 'AIzaSyDDoU-OX0rL-p06QWqGtHq-GdorZ-M-aoY';
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $url,
            'key' => $apiKey,
        ]);

        $data = $response->json();

        if (!empty($data['results']) && isset($data['results'][0]['geometry']['location'])) {
            return [
                'latitude' => $data['results'][0]['geometry']['location']['lat'],
                'longitude' => $data['results'][0]['geometry']['location']['lng'],
            ];
        }

        return null;
    }
}

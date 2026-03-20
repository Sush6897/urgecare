<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZohoController extends Controller
{
    //

    public function index(){
        // $scopes = [
        //     'ZohoBigin.users.ALL',
        //     'ZohoBigin.users.READ',
        //     'ZohoBigin.users.CREATE',
        //     'ZohoBigin.users.WRITE',
        //     'ZohoBigin.users.DELETE',
        //     'ZohoBigin.org.ALL',
        //     'ZohoBigin.org.READ',
        //     'ZohoBigin.org.CREATE',
        //     'ZohoBigin.org.WRITE',
        //     'ZohoBigin.settings.ALL',
        //     'ZohoBigin.settings.modules.ALL',
        //     'ZohoBigin.settings.modules.READ',
        //     'ZohoBigin.settings.roles.ALL',
        //     'ZohoBigin.settings.roles.READ',
        //     'ZohoBigin.settings.profiles.ALL',
        //     'ZohoBigin.settings.profiles.READ',
        //     'ZohoBigin.settings.fields.ALL',
        //     'ZohoBigin.settings.fields.READ',
        //     'ZohoBigin.settings.layouts.ALL',
        //     'ZohoBigin.settings.layouts.READ',
        //     'ZohoBigin.settings.related_lists.ALL',
        //     'ZohoBigin.settings.related_lists.READ',
        //     'ZohoBigin.settings.custom_views.ALL',
        //     'ZohoBigin.settings.custom_views.READ',
        //     'ZohoBigin.settings.tags.ALL',
        //     'ZohoBigin.settings.tags.READ',
        //     'ZohoBigin.settings.tags.WRITE',
        //     'ZohoBigin.settings.tags.CREATE',
        //     'ZohoBigin.settings.tags.UPDATE',
        //     'ZohoBigin.settings.tags.DELETE',
        //     'ZohoBigin.modules.ALL',
        //     'ZohoBigin.modules.contacts.ALL',
        //     'ZohoBigin.modules.accounts.ALL',
        //     'ZohoBigin.modules.products.ALL',
        //     'ZohoBigin.modules.contacts.READ',
        //     'ZohoBigin.modules.accounts.READ',
        //     'ZohoBigin.modules.products.READ',
        //     'ZohoBigin.modules.contacts.CREATE',
        //     'ZohoBigin.modules.accounts.CREATE',
        //     'ZohoBigin.modules.products.CREATE',
        //     'ZohoBigin.modules.contacts.WRITE',
        //     'ZohoBigin.modules.accounts.WRITE',
        //     'ZohoBigin.modules.products.WRITE',
        //     'ZohoBigin.modules.contacts.UPDATE',
        //     'ZohoBigin.modules.accounts.UPDATE',
        //     'ZohoBigin.modules.products.UPDATE',
        //     'ZohoBigin.modules.contacts.DELETE',
        //     'ZohoBigin.modules.accounts.DELETE',
        //     'ZohoBigin.modules.products.DELETE',
        //     'ZohoBigin.bulk.ALL',
        //     'ZohoBigin.bulk.READ',
        //     'ZohoBigin.bulk.CREATE',
        //     'ZohoBigin.notifications.ALL',
        //     'ZohoBigin.notifications.READ',
        //     'ZohoBigin.notifications.WRITE',
        //     'ZohoBigin.notifications.CREATE',
        //     'ZohoBigin.notifications.UPDATE',
        //     'ZohoBigin.notifications.DELETE'

          
        // ];
        $scopes = [
            'ZohoBigin.users.ALL',
            'ZohoBigin.org.ALL',
            'ZohoBigin.settings.ALL',
            'ZohoBigin.modules.ALL',
            'ZohoBigin.bulk.ALL',
            'ZohoBigin.notifications.ALL'
        ];
        $scope = implode(',', $scopes);

        $url = "https://accounts.zoho.in/oauth/v2/auth?scope={$scope}&client_id=1000.8RVYVDWS30U5G5CXK1AJ7T96FHU0LN&response_type=code&access_type=offline&redirect_uri=http://127.0.0.1:8000/zoho";


        return redirect($url);
    }

    public function handleZohoCallback(Request $request)
    {
        $code = $request->input('code');
      
        if ($code) {
            // Exchange the authorization code for an access token
            $response = Http::asForm()->post('https://accounts.zoho.in/oauth/v2/token', [
                'code' => $code,
                'redirect_uri' =>'http://127.0.0.1:8000/zoho',
                'client_id' => '1000.8RVYVDWS30U5G5CXK1AJ7T96FHU0LN',
                'client_secret' => '270a3ce695abd80bf930bcb22f9e18c2e000cc934e',
                'grant_type' => 'authorization_code',
            ]);

            if ($response->successful()) {
                $data = $response->json();
            //    dd($data);
                // Handle the response and store the access token
                // For example, store it in the session or database
                // session(['zoho_access_token' => $data['access_token']]);
                // session(['zoho_refresh_token' => $data['refresh_token']]);
                $access_token = $data['access_token']; // Obtained from the previous step

                if ($access_token) {
                    $response = Http::withHeaders([
                        'Authorization' => 'Zoho-oauthtoken ' . $access_token,
                    ])->get('https://www.zohoapis.in/bigin/v2/Companies?fields=account_name');

                    if ($response->successful()) {
                                         dd($response->json());
                        return response()->json($response->json());
                    } else {
                        // Log the response for debugging
                        Log::error('Failed to retrieve modules: ' . $response->body());
        
                        return response()->json(['error' => 'Failed to retrieve modules'], 400);
                    }
                }
                return response()->json($data);
            } else {
                return response()->json(['error' => 'Failed to retrieve access token'], 400);
            }
        }

        return response()->json(['error' => 'Authorization code not provided'], 400);
    }


}

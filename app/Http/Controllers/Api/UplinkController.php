<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class UplinkController extends Controller
{
    public function fetchData()
    {
        $client = new Client();
        $response = $client->get('https://iotdashboard.wg.ugm.ac.id/api/uplinks/chripstack');
        $data = json_decode($response->getBody(), true);
        
        // Assuming the data structure
        return response()->json([
            'frequency' => $data['frequency'], // Replace with actual path
            'voltage' => $data['voltage'], // Replace with actual path
        ]);
    }
}

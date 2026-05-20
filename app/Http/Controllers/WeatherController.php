<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use RakibDevs\Weather\Weather;

class WeatherController extends Controller
{
    public function index()
    {
        $weather = new Weather();

        $weatherByCity = 'Sambas, West Kalimantan';
        
        $weather3Hourly = $weather->get3HourlyByCity($weatherByCity);

        return response()->json([
            'weather3Hourly' => $weather3Hourly
        ]);
        
    }
}

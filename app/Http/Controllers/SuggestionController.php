<?php
//Author : Nicholas Yap Jia Wey
namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function getCurrentWeatherSuggestion(Request $request)
    {
        // Fetch the suggestion for the current weather
        $suggestion = $this->weatherService->getCurrentWeatherSuggestion();

        return $suggestion;
    }
}
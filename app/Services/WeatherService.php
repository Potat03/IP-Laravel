<!--Nicholas Yap Jia Wey-->
<?php

namespace App\Services;

use GuzzleHttp\Client;
use Carbon\Carbon;
use Exception;

class WeatherService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getCurrentWeatherSuggestion()
    {
        try {
            $apiKey = env('WEATHER_API_KEY');
            $location = 'Tokyo'; 
            $url = "https://api.openweathermap.org/data/2.5/weather?q={$location}&appid={$apiKey}&units=metric";

            $response = $this->client->get($url);
            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['main']['temp'])) {
                $temperature = $data['main']['temp'];
                return $this->suggestByTemperature($temperature);
            }

            return 'No suggestion available.';
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching the weather data.'], 500);
        }
    }

    protected function suggestByTemperature($temperature)
    {
        $suggestions = [
            "hot_days_above_25" => [
                "Sizzling Summer Steals!",
                "Beat the Heat with Hot Deals!",
                "Red-Hot Picks for Warm Weather!",
                "Summer Vibes, Scorching Deals!",
                "Stay Cool with These Hot Offers!"
            ],
            "warm_days_20_to_25" => [
                "Embrace the Sunshine with Perfect Picks!",
                "Sun-Kissed Selections for You!",
                "Warm Weather Wonders Await!",
                "Bright Day, Bright Deals!",
                "Soak Up the Sun with These Finds!"
            ],
            "mild_days_15_to_20" => [
                "Mild Weather, Perfect Shopping!",
                "Easy Breezy Deals for Mild Days!",
                "The Perfect Day for Great Deals!",
                "Cool and Casual Picks for You!",
                "Mild Temperatures, Major Savings!"
            ],
            "cool_days_10_to_15" => [
                "Chill Vibes, Cool Deals!",
                "Cozy Comforts for Crisp Days!",
                "Stay Warm with These Cool Deals!",
                "Sweater Weather Steals!",
                "Cool Day, Hot Offers!"
            ],
            "cold_days_0_to_10" => [
                "Bundle Up with These Winter Must-Haves!",
                "Winter Essentials for Chilly Days!",
                "Cold Weather, Warm Deals!",
                "Frosty Days Call for Cozy Comforts!",
                "Stay Toasty with These Winter Picks!"
            ],
            "freezing_days_below_0" => [
                "Ice Cold Deals for Freezing Days!",
                "Winter Gear for the Frostiest Days!",
                "Stay Warm in Freezing Weather!",
                "Beat the Freeze with These Hot Offers!",
                "Frozen Weather, Hot Deals!"
            ]
        ];

        if ($temperature > 25) {
            $selectedSuggestions = $suggestions["hot_days_above_25"];
        } elseif ($temperature >= 20) {
            $selectedSuggestions = $suggestions["warm_days_20_to_25"];
        } elseif ($temperature >= 15) {
            $selectedSuggestions = $suggestions["mild_days_15_to_20"];
        } elseif ($temperature >= 10) {
            $selectedSuggestions = $suggestions["cool_days_10_to_15"];
        } elseif ($temperature >= 0) {
            $selectedSuggestions = $suggestions["cold_days_0_to_10"];
        } else {
            $selectedSuggestions = $suggestions["freezing_days_below_0"];
        }

        return response()->json(['message' => "Today's weather is {$temperature}°C. Here's a suggestion for you: " . $selectedSuggestions[array_rand($selectedSuggestions)]]);
    }
}

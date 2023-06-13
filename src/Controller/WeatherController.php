<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WeatherController extends AbstractController
{
    #[Route('/fetch-weather', name: 'fetch_weather', methods: ['GET'])]
    public function getWeatherData(): JsonResponse
    {
        $latitude = 45.75; // Latitude Lyon FRANCE
        $longitude = 4.85; // Longitude Lyon FRANCE

        $params = [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'current_weather'=> "true",
            'timezone' => 'Europe/Paris',
        ];

        // Make a request to the Open-Meteo API to get the temperature
        $url = 'https://api.open-meteo.com/v1/forecast?' . http_build_query($params);
    
        $response = file_get_contents($url);
        $weatherData = json_decode($response, true);

        // Extract the temperature from the JSON response
        $temperature = $weatherData['current_weather']['temperature'];

        // Return the temperature as a JSON response
        return new JsonResponse(['temperature' => $temperature ]);
  
    }
}

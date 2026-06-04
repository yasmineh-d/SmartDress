<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherService{
    public function getMeteo(string $city = null, string $country = null): array
    {
        $city    = $city    ?? config('services.openweather.city', 'Casablanca');
        $country = $country ?? config('services.openweather.country', 'MA');
        $apiKey  = config('services.openweather.key');

        // Cache 30 minutes pour ne pas dépasser la limite gratuite
        return Cache::remember("meteo_{$city}", 1800, function () use ($city, $country, $apiKey) {

            if (!$apiKey) {
                return $this->getDefaults($city);
            }

            $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                'q'     => "{$city},{$country}",
                'appid' => $apiKey,
                'units' => 'metric',
                'lang'  => 'fr',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'ville'       => $data['name'],
                    'temperature' => round($data['main']['temp']),
                    'description' => ucfirst($data['weather'][0]['description']),
                    'icone'       => $this->getEmoji($data['weather'][0]['main']),
                    'humidite'    => $data['main']['humidity'],
                    'vent'        => round($data['wind']['speed']),
                ];
            }

            return $this->getDefaults($city);
        });
    }

    private function getDefaults(string $city): array
    {
        return [
            'ville'       => $city,
            'temperature' => 24,
            'description' => 'Ensoleillé',
            'icone'       => '☀️',
            'humidite'    => 50,
            'vent'        => 10,
        ];
    }

    private function getEmoji(string $condition): string
    {
        return match($condition) {
            'Clear'        => '☀️',
            'Clouds'       => '⛅',
            'Rain'         => '🌧️',
            'Drizzle'      => '🌦️',
            'Thunderstorm' => '⛈️',
            'Snow'         => '❄️',
            'Mist', 'Fog'  => '🌫️',
            'Haze'         => '🌁',
            default        => '🌤️',
        };
    }
}
<?php

namespace App\Services;

class WeatherService
{
    /**
     * Récupère la température actuelle pour une ville donnée.
     * Note : Pour cet exemple, on simule une température selon la ville.
     * Dans un vrai projet, on ferait un appel à l'API OpenWeather.
     * 
     * @param string $city
     * @return float
     */
    public function getCurrentTemperature(string $city): float
    {
        // Simulation d'une API de météo
        switch (strtolower($city)) {
            case 'paris':
                return 12.5; // Frais
            case 'marseille':
                return 26.0; // Chaud
            case 'montreal':
                return -5.0; // Très froid
            default:
                // Température par défaut
                return 20.0;
        }
    }

    /**
     * Détermine si le temps est considéré comme "froid" ou "chaud" pour s'habiller.
     */
    public function getWeatherCondition(float $temperature): string
    {
        if ($temperature < 15) {
            return 'Hiver';
        }

        return 'Été';
    }
}

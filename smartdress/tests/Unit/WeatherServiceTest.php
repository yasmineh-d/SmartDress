<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Services\WeatherService;

class WeatherServiceTest extends TestCase
{
    private WeatherService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new WeatherService();
    }

    /** @test */
    public function it_returns_mocked_temperature_for_known_cities()
    {
        $this->assertEquals(12.5, $this->service->getCurrentTemperature('Paris'));
        $this->assertEquals(26.0, $this->service->getCurrentTemperature('marseille'));
        $this->assertEquals(-5.0, $this->service->getCurrentTemperature('Montreal'));
    }

    /** @test */
    public function it_returns_default_temperature_for_unknown_cities()
    {
        $this->assertEquals(20.0, $this->service->getCurrentTemperature('Londres'));
    }

    /** @test */
    public function it_determines_weather_condition_based_on_temperature()
    {
        // Froid (Hiver)
        $this->assertEquals('Hiver', $this->service->getWeatherCondition(10));
        $this->assertEquals('Hiver', $this->service->getWeatherCondition(-5));
        
        // Chaud (Été)
        $this->assertEquals('Été', $this->service->getWeatherCondition(15));
        $this->assertEquals('Été', $this->service->getWeatherCondition(30));
    }
}

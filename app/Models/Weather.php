<?php
declare(strict_types=1);

namespace App\Models;

class Weather
{
    private string $weather;
    private float $temperature;

    public function __construct(string $weather, float $temperature)
    {

        $this->weather = $weather;
        $this->temperature = $temperature;
    }

    public function getWeather(): string
    {
        return $this->weather;
    }

    public function getTemperature(): string
    {
        return $this->temperature . '°C';
    }
}
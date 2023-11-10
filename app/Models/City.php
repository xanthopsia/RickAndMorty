<?php

namespace App\Models;

use Carbon\Carbon;

class City
{
    private string $name;
    private Carbon $time;
    private Weather $weather;

    public function __construct(
        string $name,
        Carbon $time,
        Weather $weather
    )
    {
        $this->name = $name;
        $this->time = $time;
        $this->weather = $weather;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTime(): Carbon
    {
        return $this->time;
    }

    public function getWeather(): Weather
    {
        return $this->weather;
    }
}
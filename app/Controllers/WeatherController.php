<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\City;
use App\Models\Weather;
use App\WeatherApi;

class WeatherController
{
    private const DEFAULT_CITY = 'Riga';

    private WeatherApi $api;

    public function __construct()
    {
        $this->api = new WeatherApi();
    }

    public function index(): City
    {
        $city = $_GET['city'] ?? $this::DEFAULT_CITY;

        return $this->api->fetchWeatherData($city);
    }
}
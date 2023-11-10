<?php
declare(strict_types=1);

namespace App;

use App\Models\City;
use App\Models\Weather;
use Carbon\Carbon;
use GuzzleHttp\Client;

class WeatherApi
{
    private const BASE_URL = 'https://api.openweathermap.org/data/2.5/weather?';

    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false,
        ]);
    }

    public function fetchWeatherData(string $city): City
    {
        $query = http_build_query([
            'q' => $city,
            'appid' => $_ENV['WEATHER_API_KEY'],
            'units' => 'metric',
        ]);

        $url = $this::BASE_URL . $query;

        $response = $this->client->get($url);

        $weatherData = json_decode($response->getBody()->getContents());

        $weather = new Weather(
            $weatherData->weather[0]->description,
            $weatherData->main->temp,
        );

        $timezoneOffset = $weatherData->timezone;
        $utcTime = Carbon::now();

        $localTime = $utcTime->addSeconds($timezoneOffset);

        return new City(
            $weatherData->name,
            $localTime,
            $weather,
        );
    }
}
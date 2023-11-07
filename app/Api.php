<?php

declare(strict_types=1);

namespace App;

use App\Collections\CharacterCollection;
use App\Collections\EpisodeCollection;
use App\Models\Character;
use App\Models\Episode;
use Carbon\Carbon;
use GuzzleHttp\Client;

class Api
{
    private const API_URL = 'https://rickandmortyapi.com/api/episode';
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false
        ]);
    }

    public function fetchEpisode(int $id): Episode
    {
        $response = $this->client->get(self::API_URL . "/{$id}");

        $result = json_decode((string)$response->getBody());

        return new Episode(
            $result->id,
            $result->name,
            Carbon::parse($result->air_date),
            $result->episode,
            $this->fetchCharacters($result->characters),
        );
    }

    public function fetchCharacters(array $characterUrls): CharacterCollection
    {
        $characters = new CharacterCollection();

        foreach ($characterUrls as $url) {
            $response = $this->client->get($url);

            if ($response->getStatusCode() !== 200) {
                continue;
            }

            $data = json_decode($response->getBody()->getContents());

            $character = new Character(
                $data->name,
                $data->image
            );

            $characters->add($character);
        }

        return $characters;
    }

    public function fetchSeasons(): array
    {
        $episodes = $this->fetchEpisodes();
        $seasons = [];

        /** @var Episode $episode */
        foreach ($episodes->get() as $episode) {
            $episodeSeason = (int)substr($episode->getEpisode(), 1, 2);
            $seasons[] = [
                'season_id' => $episodeSeason
            ];
        }
        ksort($seasons);

        return array_values(array_unique(array_column($seasons, 'season_id')));
    }

    public function fetchEpisodes(): EpisodeCollection
    {
        $episodes = new EpisodeCollection();

        $page = 1;

        while (true) {
            $response = $this->client->get(self::API_URL . "?page=$page");

            $data = json_decode((string)$response->getBody());

            foreach ($data->results as $result) {
                $episode = new Episode(
                    $result->id,
                    $result->name,
                    Carbon::parse($result->air_date),
                    $result->episode,
                );

                $episodes->add($episode);
            }

            $page++;

            if ($data->info->next == null) {
                break;
            }
        }

        return $episodes;
    }

    public function fetchEpisodesBySeasonId(int $seasonId): EpisodeCollection
    {
        $episodes = new EpisodeCollection();

        /** @var Episode $episode */
        foreach ($this->fetchEpisodes()->get() as $episode) {
            $episodeSeason = (int)substr($episode->getEpisode(), 1, 2);

            if ($episodeSeason === $seasonId) {
                $episode = new Episode(
                    $episode->getId(),
                    $episode->getName(),
                    $episode->getAirDate(),
                    $episode->getEpisode(),
                );

                $episodes->add($episode);
            }
        }

        return $episodes;
    }
}

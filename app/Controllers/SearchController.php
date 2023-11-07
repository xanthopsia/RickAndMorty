<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Api;
use App\Response;

class SearchController
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function index(): Response
    {
        $queryParameters = $_GET;
        $search = (string)$queryParameters['episode'];

        $episodes = $this->api->fetchEpisodes();
        $episodeId = $episodes->getEpisodeId($search);

        if (empty($episodeId)) {
            return new Response('not-found', []);
        }

        $episode = $this->api->fetchEpisode($episodeId);

        $data = ['episode' => $episode];
        return new Response('episodes/show', $data);
    }
}

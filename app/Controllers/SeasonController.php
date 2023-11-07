<?php

namespace App\Controllers;

use App\Api;
use App\Collections\EpisodeCollection;
use App\Collections\SeasonCollection;
use App\Response;

class SeasonController
{
    private Api $api;
    private EpisodeCollection $episodes;

    public function __construct()
    {
        $this->api = new Api();
        $this->episodes = new EpisodeCollection();
    }

    public function index(): Response
    {
        return new Response(
            'seasons/index',
            [
                'seasons' => $this->api->fetchSeasons(),
                'header' => 'Seasons'
            ]
        );
    }

    public function show(array $vars): Response
    {
        $id = (int)$vars['id'];

        return new Response(
            'seasons/show',
            [
                'episodes' => $this->api->fetchEpisodesBySeasonId($id)->get(),
                'header' => 'Seasons'
            ]
        );
    }
}
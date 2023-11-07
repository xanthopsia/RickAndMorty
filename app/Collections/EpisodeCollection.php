<?php

namespace App\Collections;

use App\Models\Episode;

class EpisodeCollection
{
    private array $episodes = [];

    public function add(Episode $episode): void
    {
        $this->episodes[] = $episode;
    }

    public function getEpisodeId(string $seasonEpisode): ?int
    {
        $episode = array_filter($this->get(), function ($episode) use ($seasonEpisode) {
            return $episode->getEpisode() === $seasonEpisode;
        });

        if (!empty($episode)) {
            $episode = reset($episode);
            return $episode->getId();
        }

        return null;
    }

    public function get(): array
    {
        return $this->episodes;
    }

}
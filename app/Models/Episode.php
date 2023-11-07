<?php

declare(strict_types=1);

namespace App\Models;

use App\Collections\CharacterCollection;
use Carbon\Carbon;

class Episode
{
    private int $id;
    private string $name;
    private Carbon $airDate;
    private string $episode;
    private ?CharacterCollection $characters;

    public function __construct(
        int                 $id,
        string              $name,
        Carbon              $airDate,
        string              $episode,
        CharacterCollection $characters = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->airDate = $airDate;
        $this->episode = $episode;
        $this->characters = $characters;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAirDate(): Carbon
    {
        return $this->airDate;
    }

    public function getEpisode(): string
    {
        return $this->episode;
    }

    public function getCharacters(): array
    {
        return $this->characters->get();
    }
}
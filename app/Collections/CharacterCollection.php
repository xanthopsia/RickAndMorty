<?php

namespace App\Collections;

use App\Models\Character;

class CharacterCollection
{
    private array $characters;

    public function add(Character $character): void
    {
        $this->characters[] = $character;
    }

    public function get(): array
    {
        return $this->characters;
    }
}
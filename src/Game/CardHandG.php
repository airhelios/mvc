<?php

namespace App\Game;

use App\Game\CardG;

class CardHandG
{
    private $hand = [];

    public function add(CardG $card): void
    {
        $this->hand[] = $card;
    }

    public function roll(): void
    {
        foreach ($this->hand as $card) {
            $card->roll();
        }
    }

    public function getNumberCards(): int
    {
        return count($this->hand);
    }

    public function getValues(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getValue();
        }
        return $values;
    }

    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }
    public function getAsColor(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getAsColor();
        }
        return $values;
    }
}

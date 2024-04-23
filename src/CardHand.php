<?php

namespace App\Card;

use App\Card\Card;

class CardHand
{
    /**
     * @var Card[]
     */
    private array $hand = [];

    public function add(Card $card): void
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

    /**
    * @return array<mixed>
    */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getValue();
        }
        return $values;
    }

    /**
    * @return array<mixed>
    */
    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }

    /**
     * @return array<mixed>
     */
    public function getAsColor(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getAsColor();
        }
        return $values;
    }
}

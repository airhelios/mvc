<?php

namespace App\Game;

use App\Game\CardGraphicG;

class DeckOfCardsG
{
    /**
     * @var CardG[]
     */
    private array $deck = [];

    public function __construct()
    {
        $values = range(0, 51);
        shuffle($values);

        foreach($values as $val) {
            $card = new CardGraphicG();

            $cardColor = (int)floor($val / 13);
            $card->setColor($cardColor);
            $card->setValue($val % 13 + 1);
            $this->deck[] = $card;
        }
    }

    public function draw(): ?CardG
    {
        return array_shift($this->deck);
    }

    public function getNumberCards(): int
    {
        return count($this->deck);
    }

    /**
     * @return array<mixed>
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
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
        foreach ($this->deck as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }

    /**
     * @return array<mixed>
     */
    public function getColor(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
            $values[] = $card->getAsColor();
        }
        return $values;
    }
}

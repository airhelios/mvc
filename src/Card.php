<?php

namespace App\Card;


class Card
{
    protected $value;

    public const COLORS = ['Spades', 'Heart', 'Diamonds', 'Clubs'];
    public const CARDS = ["Ace", "2", "3", "4", "5", "6", "7", "8", "9", "10", "Jack", "Queen", "King"];

    public function __construct()
    {
        $this->value = random_int(0, 51);
    }

    public function roll(): int
    {
        $this->value = random_int(0, 51);
        return $this->value;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }


    public function getAsString(): string
    {
        $card_color = floor(($this->value) / 13);
        $card = $this->value % 13;
        // {self::COLORS[$card_number]}
        return self::CARDS[$card] . " of " . self::COLORS[$card_color];
    }

    public function getAsColor(): string
    {
        $card_color = floor($this->value / 13);
        return self::COLORS[$card_color];
    }
}

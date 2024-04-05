<?php

namespace App\Card;

class Card
{
    protected $value;
    private $value_as_string;

    protected const COLORS = ['Spades', 'Heart', 'Diamonds', 'Clubs'];
    protected const CARDS = ["Ace", "2", "3", "4", "5", "6", "7", "8", "9", "10", "Jack", "Queen", "King"];

    public function __construct()
    {
        $this->value = null;
    }

    public function roll(): int
    {
        $this->value = random_int(1, 52);
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
        $card_color = floor($this->value/13);
        $card = $this->value % 13;
        // {self::COLORS[$card_number]}
        return self::CARDS[$card] . " of " . self::COLORS[$card_color];
    }
}

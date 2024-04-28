<?php

namespace App\Game;

class CardG implements CardInterfaceG
{
    protected int $value;
    protected int $color;

    public const COLORS = ['Spades', 'Heart', 'Diamonds', 'Clubs'];
    public const CARDS = ["Ace", "2", "3", "4", "5", "6", "7", "8", "9", "10", "Jack", "Queen", "King"];

    public function __construct()
    {
        $this->value = random_int(1, 13);
        $this->color = random_int(0, 3);
    }

    public function roll(): void
    {
        $this->value = random_int(1, 13);
        $this->color = random_int(0, 3);
    }

    public function setValue(int $value): void
    {
        if ($value > 0 && $value <= 13) {
            $this->value = $value;
        }
    }

    public function setColor(int $color): void
    {
        if ($color >= 0 && $color <= 3) {
            $this->color = $color;
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getColor(): int
    {
        return $this->color;
    }

    public function getAsString(): string
    {
        // {self::COLORS[$card_number]}
        return self::CARDS[$this->value - 1] . " of " . self::COLORS[$this->color];
    }

    public function getAsColor(): string
    {
        return self::COLORS[$this->color];
    }
}

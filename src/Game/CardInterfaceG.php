<?php

namespace App\Game;
interface CardInterfaceG
{

    public const COLORS = ['Spades', 'Heart', 'Diamonds', 'Clubs'];
    public const CARDS = ["Ace", "2", "3", "4", "5", "6", "7", "8", "9", "10", "Jack", "Queen", "King"];

    public function roll(): int;
    public function setValue($value): void;

    public function getValue(): int;
    public function getAsString(): string;
    public function getAsColor(): string;
}

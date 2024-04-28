<?php

namespace App\Game;

interface CardInterfaceG
{
    public const COLORS = ['Spades', 'Heart', 'Diamonds', 'Clubs'];
    public const CARDS = ["Ace", "2", "3", "4", "5", "6", "7", "8", "9", "10", "Jack", "Queen", "King"];


    // public function roll(): void;
    public function setValue(int $value): void;
    public function setColor(int $color): void;
    public function getValue(): int;
    public function getAsString(): string;
    public function getAsColor(): string;
    public function getColor(): int;
}

<?php

namespace App\Card;

use App\Card\Card;

class DeckOfCards
{

    private  $deck = [];
    private $values;

    public function __construct()
    {
        $values = range(1, 52);
        shuffle($values);

        for ($i = 0; $i < $values; $i++) {
            $card = new Card();
            $card->setValue($values[$i]);
            $deck[] = $card;
        }
    }

    public function giveHand($num): array
    {
        $hand = [];

        for ($i = 0; $i < $num; $i++) {
            if (sizeof($this->deck) > 0) {
            $hand[] = array_pop($this->deck);
            }
        }
        return $hand;
    }

    
    public function giveHandValues($num): array
    {
        $hand = [];

        for ($i = 0; $i < $num; $i++) {
            if (sizeof($this->deck) > 0) {
            $hand[] = array_pop($this->deck);
            }
        }
        return $hand;
    }

    
    public function giveHandString($num): array
    {
        $hand = [];

        for ($i = 0; $i < $num; $i++) {
            if (sizeof($this->deck) > 0) {
            $hand[] = array_pop($this->deck);
            }
        }
        return $hand;
    }

    public function getNumberCards(): int
    {
        return count($this->deck);
    }

    public function getValues(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
            $values[] = $card->getValue();
        }
        return $values;
    }

    public function getString(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }
}

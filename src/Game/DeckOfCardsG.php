<?php

namespace App\Game;

use App\Game\CardGraphicG;

class DeckOfCardsG
{
    private $deck = [];
    private $values;

    public function __construct()
    {
        $values = range(0, 51);
        shuffle($values);

        foreach($values as $val) {
            $card = new CardGraphicG();
            $card->setValue($val);
            $this->deck[] = $card;
        }
    }

    public function draw(): CardG
    {
       return array_shift($this->deck);
    }

    //#region hand functions
    // public function giveHand($num): array
    // {
    //     $hand = [];

    //     for ($i = 0; $i < $num; $i++) {
    //         if (sizeof($this->deck) > 0) {
    //             $hand[] = array_pop($this->deck);
    //         }
    //     }
    //     return $hand;
    // }
 
    // public function giveHandValues($num): array
    // {
    //     $hand = [];
    //     for ($i = 0; $i < $num; $i++) {
    //         if (sizeof($this->deck) > 0) {
    //             $value = array_shift($this->deck);
    //             $hand[] = $value->getValue();
    //         }
    //     }
    //     return $hand;
    // }

    // public function giveHandString($num): array
    // {
    //     $hand = [];

    //     for ($i = 0; $i < $num; $i++) {
    //         if (sizeof($this->deck) > 0) {
    //             $hand[] = array_shift($this->deck);
    //         }
    //     }
    //     return $hand;
    // }
    //#enregion
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

    public function getColor(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
            $values[] = $card->getAsColor();
        }
        return $values;
    }
}

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
    public function getCards(): array
    {
        return $this->hand;
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

    public function sumValue(): array
    {
        $total = [0];
        foreach ($this->hand as $card) {
            
            if ($card->getValue() == 1) { //Ace
                $total_one = array_map(function ($a) { return $a + 1; }, $total); //Add 1
                $total_eleven = array_map(function ($a) { return $a + 11; }, $total); // 11
                $total = array_merge($total_one, $total_eleven);
            } else if ($card->getValue() >= 10) { //Jack up to King
                $total = array_map(function ($a) { return $a + 10; }, $total); //Add 10
            } else { //Others
                $val = $card->getValue();
                for ( $i = 0; $i < count($total); $i++ ) {
                    $total[$i] = $total[$i] + $val;
                }
            }
        }
        return $total;
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

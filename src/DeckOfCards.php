<?php

namespace App\Card;

use App\Card\CardGraphic;

class DeckOfCards
{
    /**
     * @var Card[]
     */
    private array $deck = [];

    public function __construct()
    {
        $values = range(0, 51);
        shuffle($values);

        foreach($values as $val) {
            $card = new CardGraphic();
            $card->setValue($val);
            $this->deck[] = $card;
        }
    }

    /**
     * @param int $num
     * @return array<mixed>
     */
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

    /**
     * @param int $num
     * @return array<mixed>
     */
    public function giveHandValues($num): array
    {
        $hand = [];
        for ($i = 0; $i < $num; $i++) {
            if (sizeof($this->deck) > 0) {
                $value = array_shift($this->deck);
                $hand[] = $value->getValue();
            }
        }
        return $hand;
    }

    /**
     * @param int $num
     * @return array<mixed>
     */
    public function giveHandString(int $num): array
    {
        $hand = [];

        for ($i = 0; $i < $num; $i++) {
            if (sizeof($this->deck) > 0) {
                $hand[] = array_shift($this->deck);
            }
        }
        return $hand;
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

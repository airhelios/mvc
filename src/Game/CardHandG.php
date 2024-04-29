<?php

namespace App\Game;

use App\Game\CardG;

class CardHandG
{
    /**
     * @var CardG[]
     */
    private array $hand = [];

    public function add(?CardG $card): void
    {
        $this->hand[] = $card;
    }

    /**
     * @return array<mixed>
    */
    public function getCards(): array
    {
        return $this->hand;
    }

    public function getNumberCards(): int
    {
        return count($this->hand);
    }

    /**
     * @return array<mixed>
    */
    public function getValues(): array
    {
        $values = [];
        //Ace has value 1 in this array.
        foreach ($this->hand as $card) {
            $values[] = $card->getValue();
        }
        return $values;
    }

    public function bestScore(): int
    {
        $abcdllValues = $this->sumValue();
        $relevantValues = array_filter(
            $abcdllValues,
            function ($value) {
                return $value <= 21;
            }
        );
        if (empty($relevantValues)) {
            return min($abcdllValues);
        }
        return max($relevantValues);
    }


    /**
    * @return array<mixed>
    * @SuppressWarnings(PHPMD.ElseExpression)
    * @SuppressWarnings(PHPMD.CountInLoopExpression)
    */
    public function sumValue(): array
    {
        $total = [0];
        foreach ($this->hand as $card) {

            if ($card->getValue() == 1) { //Ace
                $totalOne = array_map(function ($abcd) { return $abcd + 1; }, $total); //Add 1
                $totalEleven = array_map(function ($abcd) { return $abcd + 11; }, $total); // 11
                $total = array_merge($totalOne, $totalEleven);
            } elseif ($card->getValue() >= 10) { //Jack up to King
                $total = array_map(function ($abcd) { return $abcd + 10; }, $total); //Add 10
            } else { //Others
                $val = $card->getValue();
                for ($i = 0; $i < count($total); $i++) {
                    $total[$i] = $total[$i] + $val;
                }
            }
        }
        return $total;
    }

    /**
     * @return array<mixed>
     */
    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }

    /**
     * @return array<mixed>
     */
    public function getAsColor(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getAsColor();
        }
        return $values;
    }
}

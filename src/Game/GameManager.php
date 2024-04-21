<?php

namespace App\Game;
class GameManager
{
    private CardHandG $playerHand;
    private CardHandG $machineHand;
    protected DeckOfCardsG $deck;
    protected $status; //Is Game over or still going?
    protected $winner;
    protected $currentPlayer;

    
    public function __construct(CardHandG $playerHand, CardHandG $machineHand, DeckOfCardsG $deck)
    {
        $this->playerHand = $playerHand;
        $this->machineHand = $machineHand;
        $this->deck = $deck;
        $this->playerHand->add($this->deck->draw());
        $this->winner = "";
        $this->currentPlayer = "player";
    }
    public function getGameStatus()
    {
        if ($this->status != "over" || $this->winner != "") {
            return "ongoing";
        }
        return "over";
    }

    public function getPlayerHand()
    {
        return $this->playerHand->getCards();
    }

    public function setWinner($winner)
    {
        $this->winner = $winner;
    }

    public function getWinner()
    {
        return $this->winner;
    }

    public function getScore($hand)
    {
    if ($hand == "machine") {
            return $this->machineHand->sumValue();
        }
        return $this->playerHand->sumValue();
    }

    public function drawPlayer()
    {
        $this->playerHand->add($this->deck->draw());
    }

    public function next()
    {
        if ($this->status == "over")
        {
            return "Game Over";
        } else if ($this->winner != "")
        {
            return "Game Over";
        } else if ($this->currentPlayer == "player")
        {
            if (min($this->playerHand->sumValue()) > 21)
            {
                $this->winner = "machine";
                return "Game Over";
            } else if (min($this->machineHand->sumValue()) > 21) {
                $this->winner ="player";
                return "Game Over";
            }
        }



    }

}

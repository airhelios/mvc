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

    public static function gameManagerNew() {
        $deck = new DeckOfCardsG();
        $playerHand = new CardHandG();
        $machineHand = new CardHandG();
        $gameManager = new GameManager($playerHand, $machineHand, $deck);   
        return $gameManager;
    }

    public function getGameStatus(): string
    {
        $playerScore = $this->playerHand->bestScore();
        $machineScore = $this->machineHand->bestScore();
        if ($playerScore > 21){
            $this->status = "player_bust";
        } else if ($machineScore > 21){
            $this->status = "house_bust";        
        } else if ($machineScore >= $playerScore)
        {
            $this->status = "house_win";

        } else {
            $this->status = "player_win";
        }
        return $this->status;
    }

    public function getPlayerHand()
    {
        return $this->playerHand->getCards();
    }

    public function getMachineHand()
    {
        return $this->machineHand->getCards();
    }

    public function getPlayerCardStrings()
    {
        $cards = [];
        foreach($this->playerHand->getCards() as $card) {
            $cards[] = $card->getAsString();
        }
        return $cards;
    }

    public function getPlayerCardColors()
    {
        $colors = [];
        foreach($this->playerHand->getCards() as $card) {
            $colors[] = $card->getAsColor();
        }
        return $colors;
    }


    public function getWinnerPhrase()
    {
        $winner_phrase = "";
        $playerScore = $this->playerHand->bestScore();
        $machineScore = $this->machineHand->bestScore();
        if ($playerScore > 21){
            $winner_phrase = "House wins because the Player went bust!";
        } else if ($machineScore > 21){
            $winner_phrase = "Player wins because the House went bust!";        
        } else if ($machineScore >= $playerScore)
        {

            $winner_phrase = "The House wins with a score of " . $machineScore . " against " . $playerScore;

        } else {
            $winner_phrase = "The Player wins with a score of " . $playerScore . " against " . $machineScore;
        }
        return $winner_phrase;
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

    public function populateMachine(): void
    {
        // The Dealer's first ace counts as 11 unless it busts the hand. Subsequent aces count as one.
        $value = 0;
        while ($value < 17)
        {
            $card = $this->deck->draw();
            $card_value = $card->getValue();
            if ($card_value == 1 && $value > 10) {
                $value += 1;
            } else if ($card_value == 1) {
                $value += 11;
            } else {
                $value += min($card_value, 10); //Queen and king have value 11/12 otherwise
            }
            $this->machineHand->add($card);
        }
    }

    public function checkPlayerHand(): string
    {
        if ($this->playerHand->bestScore() > 21)
        {
            return "bust";
        } else if ($this->playerHand->bestScore() == 21)
        {
            return "player_21";
        }
            return "playing";
    }

}

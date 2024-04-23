<?php

namespace App\Game;

class GameManager
{
    private CardHandG $playerHand;
    private CardHandG $machineHand;
    protected DeckOfCardsG $deck;
    protected ?string $status; //Is Game over or still going?
    protected string $winner;
    protected string $currentPlayer;


    public function __construct(CardHandG $playerHand, CardHandG $machineHand, DeckOfCardsG $deck)
    {
        $this->playerHand = $playerHand;
        $this->machineHand = $machineHand;
        $this->deck = $deck;
        $this->playerHand->add($this->deck->draw());
        $this->winner = "";
        $this->currentPlayer = "player";
        $this->status = "player_turn";
    }

    public static function gameManagerNew(): GameManager
    {
        $deck = new DeckOfCardsG();
        $playerHand = new CardHandG();
        $machineHand = new CardHandG();
        $gameManager = new GameManager($playerHand, $machineHand, $deck);
        return $gameManager;
    }


    /**
    * @SuppressWarnings(PHPMD.ElseExpression)
    */
    public function getGameStatus(): string
    {
        $playerScore = $this->playerHand->bestScore();
        $machineScore = $this->machineHand->bestScore();
        if ($playerScore > 21) {
            $this->status = "player_bust";
        } elseif ($machineScore > 21) {
            $this->status = "house_bust";
        } elseif ($machineScore >= $playerScore && $this->currentPlayer == "machine") {
            $this->status = "house_win";

        } elseif ($machineScore < $playerScore && $this->currentPlayer == "machine") {
            $this->status = "player_win";
        }
        return $this->status;
    }

    public function setPlayerMachine(): void
    {
        $this->currentPlayer = "machine";
    }


    /**
     * @return array<mixed>
     */
    public function getPlayerHand(): array
    {
        return $this->playerHand->getCards();
    }

    /**
     * @return array<mixed>
     */
    public function getMachineHand(): array
    {
        return $this->machineHand->getCards();
    }

    /**
     * @return array<mixed>
     */
    public function getPlayerCardStrings(): array
    {
        $cards = [];
        foreach($this->playerHand->getCards() as $card) {
            $cards[] = $card->getAsString();
        }
        return $cards;
    }

    /**
    * @return array<mixed>
    */
    public function getPlayerCardStringsParent(): array
    {
        $cards = [];
        foreach($this->playerHand->getCards() as $card) {
            $cards[] = $card->getAsStringParent();
        }
        return $cards;
    }

    /**
     * @return array<mixed>
     */
    public function getPlayerCardColors(): array
    {
        $colors = [];
        foreach($this->playerHand->getCards() as $card) {
            $colors[] = $card->getAsColor();
        }
        return $colors;
    }

    /**
    * @return array<mixed>
    */
    public function getMachineCardStrings(): array
    {
        $cards = [];
        foreach($this->machineHand->getCards() as $card) {
            $cards[] = $card->getAsString();
        }
        return $cards;
    }

    /**
    * @return array<mixed>
    */
    public function getMachineCardStringsParent(): array
    {
        $cards = [];
        foreach($this->machineHand->getCards() as $card) {
            $cards[] = $card->getAsStringParent();
        }
        return $cards;
    }

    /**
    * @return array<mixed>
    */
    public function getMachineCardColors(): array
    {
        $colors = [];
        foreach($this->machineHand->getCards() as $card) {
            $colors[] = $card->getAsColor();
        }
        return $colors;
    }

    public function getWinnerPhrase(): string
    {
        $winnerPhrase = "";
        $playerScore = $this->playerHand->bestScore();
        $machineScore = $this->machineHand->bestScore();
        $winnerPhrase = "The Player wins with a score of " . $playerScore . " against " . $machineScore;
        if ($playerScore > 21) {
            $winnerPhrase = "House wins because the Player went bust!";
        } elseif ($machineScore > 21) {
            $winnerPhrase = "Player wins because the House went bust!";
        } elseif ($machineScore >= $playerScore) {
            $winnerPhrase = "The House wins with a score of " . $machineScore . " against " . $playerScore;
        }
        return $winnerPhrase;
    }

    public function getBestPlayerScore(): int
    {
        return $this->playerHand->bestScore();
    }

    public function getBestMachineScore(): int
    {
        return $this->machineHand->bestScore();
    }

    /**
     * @param string $hand
     * @return array<mixed>
     */
    public function getScore(string $hand): array
    {
        if ($hand == "machine") {
            return $this->machineHand->sumValue();
        }
        return $this->playerHand->sumValue();
    }

    public function drawPlayer(): void
    {
        $this->playerHand->add($this->deck->draw());
    }

    public function populateMachine(): void
    {
        // The Dealer's first ace counts as 11 unless it busts the hand. Subsequent aces count as one.
        $value = 0;
        while ($value < 17) {
            $card = $this->deck->draw();
            $cardValue = $card->getValue();
            $addVal = min($cardValue, 10); //J-K are counted as 10
            if ($cardValue == 1 && $value > 10) {
                $addVal = 1;
            } elseif ($cardValue == 1) {
                $addVal = 11;
            }
            $value += $addVal;
            $this->machineHand->add($card);
        }
    }

    public function checkPlayerHand(): string
    {
        if ($this->playerHand->bestScore() > 21) {
            return "bust";
        } elseif ($this->playerHand->bestScore() == 21) {
            return "player_21";
        }
        return "playing";
    }

}

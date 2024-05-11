<?php

namespace App\Game;

/**
 * GameManager class, game logic is implemented here. It also keeps track of
 * game status, the player hand, the house hand and the deck.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class GameManager
{
    private CardHandG $playerHand;
    private CardHandG $machineHand;
    protected DeckOfCardsG $deck;
    protected ?string $status; //Is Game over or still going?
    protected string $winner;
    protected string $currentPlayer;


    /**
     * Default constructor for GameManager Class.
     * @param CardHandG $playerHand - Players hand.
     * @param CardHandG $machineHand - House hand.
     * @param DeckOfCardsG $deck - Deck of cards.
     */
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

    /**
     * Static method to create a new instance of Game Manager where the
     * $playerHand, $machineHand and $deck is created in the method (factory method)
     * @return GameManager - new GameManager object.
     */
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
    /**
     * Returns the current status of the game.
     * @return string - $this->status property
     */
    public function getGameStatus(): ?string
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

    /**
     * Changes current player (currentPlayer property) to "machine".
     */
    public function setPlayerMachine(): void
    {
        $this->currentPlayer = "machine";
    }

    /**
     * Returns the currentPlayer-property
     */
    public function getCurrentPlayer(): string
    {
        return $this->currentPlayer;
    }


    /**
     * Returns the cards in the player's hand.
     * @return array<mixed>
     */
    public function getPlayerHand(): array
    {
        return $this->playerHand->getCards();
    }

    /**
     * Returns the cards in the house's hand.
     * @return array<mixed>
     */
    public function getMachineHand(): array
    {
        return $this->machineHand->getCards();
    }

    /**
     * Returns the player cards as an array of strings.
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
     * Returns the player cards as an array of strings (used when
     * an object of CardGraphicG is used as the card).
     * @return array<mixed>
     * */
    public function getPlayerCardStringsParent(): array
    {
        $cards = [];
        foreach($this->playerHand->getCards() as $card) {
            $cards[] = $card->getAsStringParent();
        }
        return $cards;
    }

    /**
     * Returns the colors of the player cards as an array. (Colors = spades, clubs, heart, diamonds).
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
     * Returns the house/machine cards as an array of strings.
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
     * Returns the house cards as an array of strings (used when
     * an object of CardGraphicG is used as the card).
     * @return array<mixed>
     * */
    public function getMachineCardStringsParent(): array
    {
        $cards = [];
        foreach($this->machineHand->getCards() as $card) {
            $cards[] = $card->getAsStringParent();
        }
        return $cards;
    }

    /**
     * Returns the colors of the house cards as an array. (Colors = spades, clubs, heart, diamonds).
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

    /**
     * Returns the end game phrase of who the winner was and
     * what the final scores were.
     * @return string - Winner Phrase.
     */
    public function getWinnerPhrase(): string
    {
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

    /**
     * Returns the best score the player has with the current hand.
     * The best score can vary depending on if an ace is counted as 1 or 11.
     * @return int - The best score.
     */
    public function getBestPlayerScore(): int
    {
        return $this->playerHand->bestScore();
    }

    /**
     * Returns the best score the machine has with the current hand.
     * The best score can vary depending on if an ace is counted as 1 or 11.
     * @return int - The best score.
     */
    public function getBestMachineScore(): int
    {
        return $this->machineHand->bestScore();
    }

    /**
     * Returns an array of possible scores the specified hand has. The scores can vary since
     * an ace can be counted as 1 or 11.
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

    /**
     * Makes the player hand draw another card.
     * @return CardG - Returns the card that the player drew.
     */
    public function drawPlayer(): ?CardG
    {
        $card = $this->deck->draw();
        $this->playerHand->add($card);
        return $card;
    }

    /**
     * Fills the house hand with cards until the score is 17 or above.
     * @return int - the value of the hand when the populating is done.
     */
    public function populateMachine(): int
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
        return $value;
    }

    /**
     * Checks if the player hand is bust ("bust") or 21 ("player_21") or less than 21 ("playing")
     * @return string - Status of player hand.
     */
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

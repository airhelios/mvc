<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DeckOfCardsGTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDeck(): void
    {
        $deck = new DeckOfCardsG();
        $this->assertInstanceOf("\App\Game\DeckOfCardsG", $deck);

    }

    public function testCreateDeckCount(): void
    {
        $deck = new DeckOfCardsG();
        $this->assertEquals(52, $deck->getNumberCards());
    }

    public function testDraw(): void
    {
        $deck = new DeckOfCardsG();
        $card = $deck->draw();
        $this->assertInstanceOf("\App\Game\CardG", $card);
    }

    public function testGetString(): void
    {
        $deck = new DeckOfCardsG();
        $representation = [
          '🂡','🂢','🂣','🂤','🂥','🂦','🂧','🂨','🂩','🂪','🂫','🂭','🂮',
          '🂱','🂲','🂳','🂴','🂵','🂶','🂷','🂸','🂹','🂺','🂻','🂽','🂾',
          '🃁','🃂','🃃','🃄','🃅','🃆','🃇','🃈','🃉','🃊','🃋','🃍','🃎',
          '🃑','🃒','🃓','🃔','🃕','🃖','🃗','🃘','🃙','🃚','🃛','🃝','🃞'
        ];
        $returnString = $deck->getString();
        //https://stackoverflow.com/a/13046200
        $this->assertEmpty(array_merge(
            array_diff($returnString, $representation),
            array_diff($representation, $returnString)
        ));
    }

    public function testGetValues(): void
    {
        $deck = new DeckOfCardsG();
        $representation = [];
        for ($i = 0; $i < 53; $i++) {
            $representation[] = $i % 13 + 1;
        }
        $returnValues = $deck->getValues();
        //https://stackoverflow.com/a/13046200
        $this->assertEmpty(array_merge(
            array_diff($returnValues, $representation),
            array_diff($representation, $returnValues)
        ));
    }

    public function testGetColor(): void
    {
        $deck = new DeckOfCardsG();
        $colors = ['Spades', 'Heart', 'Diamonds', 'Clubs'];
        $representation = [];
        for ($i = 0; $i < 52; $i++) {
            $representation[] = $colors[$i % 4];
        }
        $returnValues = $deck->getColor();
        //https://stackoverflow.com/a/13046200
        $this->assertEmpty(array_merge(
            array_diff($returnValues, $representation),
            array_diff($representation, $returnValues)
        ));
    }
}

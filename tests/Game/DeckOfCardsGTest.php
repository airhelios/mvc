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
    public function testCreateDeck()
    {
        $deck = new DeckOfCardsG();
        $this->assertInstanceOf("\App\Game\DeckOfCardsG", $deck);

    }

    public function testCreateDeckCount()
    {
      $deck = new DeckOfCardsG();
      $this->assertEquals(52, $deck->getNumberCards());
    }

    public function testDraw()
    {
      $hand = new CardHandG();
      $stub = $this->createMock(CardG::class);
      $hand->add($stub);

      $this->assertEquals(1, $hand->getNumberCards());
      $this->assertEquals($stub, $hand->getCards()[0]);
    }
}
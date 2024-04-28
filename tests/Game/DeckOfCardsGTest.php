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
      $deck = new DeckOfCardsG();
      $card = $deck->draw();
      $this->assertInstanceOf("\App\Game\CardG", $card);
    }
  
    public function testGetString()
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
      $this->assertEmpty(array_merge(array_diff($returnString, $representation), 
      array_diff($representation, $returnString)));
    }

    public function testGetValues()
    {
      $deck = new DeckOfCardsG();
      $representation = [];
      for ($i = 0; $i < 53; $i++) {
        $representation[] = $i % 13 + 1;
      }
      $returnValues = $deck->getValues();
      // $this->assertEquals($representation, $returnValues);
      //https://stackoverflow.com/a/13046200
      $this->assertEmpty(array_merge(array_diff($returnValues, $representation), 
      array_diff($representation, $returnValues)));
    }
}
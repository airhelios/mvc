<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class GameTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCard()
    {
        $card = new CardG();
        $this->assertInstanceOf("\App\Game\CardG", $card);

        $res = $card->getAsString();
        $this->assertNotEmpty($res);
    }

    public function testRoll()
    {
        $card = new CardG();
        $res = $card->getAsString();
        $this->assertNotEmpty($res);
    }
}
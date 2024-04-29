<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class CardGraphicGTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCard(): void
    {
        $card = new CardGraphicG();
        $this->assertInstanceOf("\App\Game\CardGraphicG", $card);

        $res = $card->getAsString();
        $this->assertNotEmpty($res);
    }

    public function testStringParent(): void
    {
        $card = new CardGraphicG();
        $this->assertInstanceOf("\App\Game\CardGraphicG", $card);
        $res = $card->getAsStringParent();
        $this->assertNotEmpty($res);
        $this->assertIsString($res);
    }
}

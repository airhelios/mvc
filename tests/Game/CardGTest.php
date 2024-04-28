<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class CardGTest extends TestCase
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

    public function testSetGetValue()
    {
        $card = new CardG();
        $card->setValue(5);
        $this->assertEquals(5, $card->getValue());
    }

    public function testSetGetColor()
    {
        $card = new CardG();
        $card->setColor(3);
        $this->assertEquals(3, $card->getColor());
        // Check that color is not more than 3
        $card->setColor(4);
        $this->assertNotEquals(4, $card->getColor());
    }

    public function testGetAsColor()
    {
        $card = new CardG();
        $this->assertContains($card->getAsColor(), ['Spades', 'Heart', 'Diamonds', 'Clubs']);
    }

    // public function testMock()
    // {
    //     $stub = $this->createMock(CardG::class);

    //     // Configure the stub.
    //     $stub->method('getValue')
    //          ->willReturn(5);
    
    //     $stub->setValue(5);
    //     $res = $stub->getValue();
    //     $exp = 5;
    //     $this->assertEquals($exp, $res);
    // }
}
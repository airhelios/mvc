<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class CardHandGTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateHand()
    {
        $hand = new CardHandG();
        $this->assertInstanceOf("\App\Game\CardHandG", $hand);

        $res = $hand->getNumberCards();
        $this->assertEquals(0, $res);
    }

    public function testAddCardToHand()
    {
        $hand = new CardHandG();
        $stub = $this->createMock(CardG::class);
        $hand->add($stub);

        $this->assertEquals(1, $hand->getNumberCards());
        $this->assertEquals($stub, $hand->getCards()[0]);
    }

    public function testGetValues()
    {
        $hand = new CardHandG();
        $testArray = [1,2,3,4];
        foreach ($testArray as $x) {
            $stub = $this->createMock(CardG::class);
            $stub->method('getValue')
            ->willReturn($x);
            $hand->add($stub);
          }
        $this->assertEquals($testArray, $hand->getValues());
    }

    public function testSumValues()
    {
        $hand = new CardHandG();
        $testArray = [1,2,3,4, 11];
        foreach ($testArray as $x) {
            $stub = $this->createMock(CardG::class);
            $stub->method('getValue')
            ->willReturn($x);
            $hand->add($stub);
          }
        $returnArray = [20, 30];
        $this->assertEquals($returnArray, $hand->sumValue());
    }

    public function testBestScore()
    {
        $hand = new CardHandG();
        $testArray = [1,2,3,4,11];
        foreach ($testArray as $x) {
            $stub = $this->createMock(CardG::class);
            $stub->method('getValue')
            ->willReturn($x);
            $hand->add($stub);
          }
        $bestScore = 20;
        $this->assertEquals($bestScore, $hand->bestScore());
    }

    public function testBestScoreEmpty()
    {
        $hand = new CardHandG();
        $testArray = [1, 11, 11, 11]; //SumValues = [31, 41]
        foreach ($testArray as $x) {
            $stub = $this->createMock(CardG::class);
            $stub->method('getValue')
            ->willReturn($x);
            $hand->add($stub);
          }
        $bestScore = 31;
        $this->assertEquals($bestScore, $hand->bestScore());
    }

    public function testGetString()
    {
        $hand = new CardHandG();
        $testArray = ["Ace of Spades", "2 of Heart"]; //SumValues = [31, 41]
        foreach ($testArray as $x) {
            $stub = $this->createMock(CardG::class);
            $stub->method('getAsString')
            ->willReturn($x);
            $hand->add($stub);
          }
        $this->assertEquals($testArray, $hand->getString());
    }

    public function testGetAsColor()
    {
        $hand = new CardHandG();
        $testArray = ["Spades", "Heart", "Diamonds"]; //SumValues = [31, 41]
        foreach ($testArray as $x) {
            $stub = $this->createMock(CardG::class);
            $stub->method('getAsColor')
            ->willReturn($x);
            $hand->add($stub);
          }
        $this->assertEquals($testArray, $hand->getAsColor());
    }
}
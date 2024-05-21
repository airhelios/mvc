<?php

namespace App\Proj;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class LevelTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testLevelConstructor(): void
    {

        $level = $this->getMockForAbstractClass(Level::class);

        // Assert the mock is an instance of Level
        $this->assertInstanceOf(Level::class, $level);
    }

    public function testLevelGetItem(): void
    {
        $hatchLevel = new HatchLevel();
        $this->assertEquals($hatchLevel->getImage(), "Hatch_DALL-E.webp");
    }

    public function testBackButton(): void
    {
        $hatchLevel = new HatchLevel();
        $this->assertEquals($hatchLevel->backButtonExists(), true);
    }

    public function testGetPrompt(): void
    {
        $hatchLevel = new HatchLevel();
        $this->assertEquals($hatchLevel->getPrompt(), "You have found a locked hatch! Open it!");
    }

    public function testSetPrompt(): void
    {
        $hatchLevel = new HatchLevel();
        $hatchLevel->setPrompt("hej");
        $this->assertEquals($hatchLevel->getPrompt(), "hej");
    }

    public function testGetItems(): void
    {
        $hatchLevel = new HatchLevel();
        $this->assertEquals($hatchLevel->getItems(), []);
    }

    public function testSetItems(): void
    {
        $hatchLevel = new HatchLevel();
        $hatchLevel->setItems(["hej"]);
        $this->assertEquals($hatchLevel->getItems(), ["hej"]);
    }

    public function testGetDoors(): void
    {
        $hatchLevel = new HatchLevel();
        $this->assertEquals($hatchLevel->getDoors(), ["Hell Portal" => [0.49, 0.415]]);
    }

    public function testSetDoors(): void
    {
        $hatchLevel = new HatchLevel();
        $testArray =  ["Hell" => [1, 1]];
        $hatchLevel->setDoors($testArray);

        $this->assertEquals($hatchLevel->getDoors(), $testArray);
    }
}

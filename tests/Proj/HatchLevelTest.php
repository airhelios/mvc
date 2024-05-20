<?php

namespace App\Proj;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class HatchLevelTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testHatchLevelConstructor(): void
    {

        $level = new HatchLevel();;
    
        // Assert the mock is an instance of Level
        $this->assertInstanceOf(HatchLevel::class, $level);
    }


    public function testNext(): void
    {
        $hatchLevel = new HatchLevel();

        $this->assertInstanceOf(HatchLevel::class, $hatchLevel->next(false, false));
        $this->assertInstanceOf(HellPortalLevel::class, $hatchLevel->next(true, false));
        $this->assertInstanceOf(BothPortalsLevel::class, $hatchLevel->next(true, true));
    }

    public function testPrevious(): void
    {
        $hatchLevel = new HatchLevel();

        $this->assertInstanceOf(EntryLevel::class, $hatchLevel->previous());
    }

    public function testCheckCoord(): void
    {
        $hatchLevel = new HatchLevel();
        $this->assertEquals("Hell Portal", $hatchLevel->checkCoord(0.49, 0.415));
        $this->assertEquals("Nothing happened", $hatchLevel->checkCoord(0, 0));
    }


}

<?php

namespace App\Proj;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class EntryLevelTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testLevelConstructor(): void
    {

        $level = new EntryLevel();;
    
        // Assert the mock is an instance of Level
        $this->assertInstanceOf(EntryLevel::class, $level);
    }

    public function testNext(): void
    {
        $entryLevel = new EntryLevel();
        $this->assertInstanceOf(HatchLevel::class, $entryLevel->next());
    }

    public function testPrevious(): void
    {
        $entryLevel = new EntryLevel();
        $this->assertInstanceOf(EntryLevel::class, $entryLevel->previous());
    }

    public function testCheckCoord(): void
    {
        $entryLevel = new EntryLevel();
        $this->assertEquals("key", $entryLevel->checkCoord(549 / 679, 550 / 679));
        $this->assertEquals("heavenly_key", $entryLevel->checkCoord(763 / 1024, 586 / 1024));
        $this->assertEquals("Hatch", $entryLevel->checkCoord(514 / 1024, 762 / 1024));
        $this->assertEquals("Nothing happened", $entryLevel->checkCoord(0, 0));
    }
}

<?php

namespace App\Proj;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class BothPortalsLevel.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class BothPortalsLevelTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testLevelConstructor(): void
    {

        $level = new BothPortalsLevel();
        ;

        // Assert the mock is an instance of Level
        $this->assertInstanceOf(BothPortalsLevel::class, $level);
    }

    public function testNext(): void
    {
        $level = new BothPortalsLevel();
        $this->assertInstanceOf(HellSceneLevel::class, $level->next(false, false, "Hell"));
        $this->assertInstanceOf(HeavenSceneLevel::class, $level->next(false, false, ""));
    }

    public function testPrevious(): void
    {
        $level = new BothPortalsLevel();
        $this->assertInstanceOf(HatchLevel::class, $level->previous());
    }

    public function testCheckCoord(): void
    {
        $level = new BothPortalsLevel();
        $this->assertEquals("Hell", $level->checkCoord(0.25, 0.49));
        $this->assertEquals("Elysium", $level->checkCoord(0.6, 0.49));
        $this->assertEquals("Nothing happened", $level->checkCoord(0.4, 0.8));
    }
}

<?php

namespace App\Proj;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class HeavenSceneLevel.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class HeavenSceneLevelTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testLevelConstructor(): void
    {

        $level = new HeavenSceneLevel();

        $this->assertInstanceOf(HeavenSceneLevel::class, $level);
    }

    public function testNext(): void
    {
        $level = new HeavenSceneLevel();
        $this->assertInstanceOf(EntryLevel::class, $level->next());
    }

    public function testPrevious(): void
    {
        $entryLevel = new HeavenSceneLevel();
        $this->assertInstanceOf(HeavenSceneLevel::class, $entryLevel->previous());
    }

    public function testCheckCoord(): void
    {
        $level = new HeavenSceneLevel();
        $this->assertEquals("Restart", $level->checkCoord(549 / 679, 550 / 679));

    }
}

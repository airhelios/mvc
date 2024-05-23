<?php

namespace App\Proj;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class HellSceneLevel.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class HellSceneLevelTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testLevelConstructor(): void
    {

        $level = new HellSceneLevel();
        ;

        $this->assertInstanceOf(HellSceneLevel::class, $level);
    }

    public function testNext(): void
    {
        $level = new HellSceneLevel();
        $this->assertInstanceOf(EntryLevel::class, $level->next());
    }

    public function testPrevious(): void
    {
        $level = new HellSceneLevel();
        $this->assertInstanceOf(HellSceneLevel::class, $level->previous());
    }

    public function testCheckCoord(): void
    {
        $level = new HellSceneLevel();
        $this->assertEquals("Restart", $level->checkCoord(549 / 679, 550 / 679));
    }
}

<?php

namespace App\Proj;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class HellPortalLevel.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class HellPortalLevelTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testLevelConstructor(): void
    {

        $level = new HellPortalLevel();
        ;


        $this->assertInstanceOf(HellPortalLevel::class, $level);
    }

    public function testNext(): void
    {
        $level = new HellPortalLevel();
        $this->assertInstanceOf(HellSceneLevel::class, $level->next());
    }

    public function testPrevious(): void
    {
        $level = new HellPortalLevel();
        $this->assertInstanceOf(HatchLevel::class, $level->previous());
    }

    public function testCheckCoord(): void
    {
        $level = new HellPortalLevel();
        $this->assertEquals("Going to hell", $level->checkCoord(0.24, 0.49));
        $this->assertEquals("Nothing happened", $level->checkCoord(0, 0));
    }
}

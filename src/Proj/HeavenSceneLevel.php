<?php

namespace App\Proj;

class HeavenSceneLevel extends Level
{
    public function __construct()
    {
        parent::__construct();
        $this->promptText = "Finally! You made it to utopia: Elysium!".
        " Your struggles were not in vain. This is your happy ending!".
        " \n\nClick anywhere on the game screen to go back to the beginning";

        $this->items = [];
        $this->doors = [];
        $this->image = "Elysian_DALL-E.webp";
        $this->backButton = false;
    }

    public function next(?bool $key = null, ?bool $heavenlyKey = null, ?string $doorName = null): Level
    {
        return new EntryLevel();
    }


    public function previous(): Level
    {
        return new HeavenSceneLevel();
    }

    public function checkCoord(float $xCoord, float $yCoord): string
    {
        return "Restart";

    }

}

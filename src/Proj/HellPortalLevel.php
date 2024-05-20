<?php

namespace App\Proj;

class HellPortalLevel extends Level
{
    public function __construct()
    {
        parent::__construct();
        $this->promptText = "There are two portals in this room. One is glowing red while the other one is not glowing at all.";
        $this->items = [];
        $this->doors = ["Going to hell" => [0.24, 0.49]];
        $this->image = "Portals_hell_DALL-E.webp";
        $this->backButton = true;
    }

    public function next(?bool $key = null, ?bool $heavenlyKey = null, ?string $doorName = null): Level
    {
        return new HellSceneLevel();
    }


    public function previous(): Level
    {
        return new HatchLevel();
    }

    public function checkCoord(float $xCoord, float $yCoord): string
    {

        $doorTolerance = 0.5;
        foreach($this->doors as $item => $value) {
            $lowerX = $value[0] * (1 - $doorTolerance);
            $lowerY = $value[1] * (1 - $doorTolerance);
            $higherX = $value[0] * (1 + $doorTolerance);
            $higherY = $value[1] * (1 + $doorTolerance);
            if (($lowerX <= $xCoord && $xCoord <= $higherX) &&
                 ($lowerY <= $yCoord && $yCoord <= $higherY)) {
                return $item;
            }
        }
        return "Nothing happened";
    }

}

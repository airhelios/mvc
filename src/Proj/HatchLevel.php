<?php

namespace App\Proj;

class HatchLevel extends Level
{
    public function __construct()
    {
        parent::__construct();
        $this->promptText = "You have found a locked hatch! Open it!";
        $this->items = [];
        $this->doors = ["Hell Portal" => [0.49, 0.415]];
        $this->image = "Hatch_DALL-E.webp";
        $this->backButton = true;
    }

    public function next(?bool $key, ?bool $heavenlyKey, ?string $doorName = null): Level
    {

        if ($heavenlyKey && $key) {
            $next = new BothPortalsLevel();
            return $next;
        } elseif ($key) {
            $next = new HellPortalLevel();
            return $next;
        }
        $next = new HatchLevel();
        $next->setPrompt("The door is locked, you need a key to open it");
        return $next;
    }


    public function previous(): Level
    {
        return new EntryLevel();
    }

    public function checkCoord(float $xCoord, float $yCoord): string
    {
        $doorTolerance = 0.20;
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

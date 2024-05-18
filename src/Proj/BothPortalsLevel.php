<?php


namespace App\Proj;



Class BothPortalsLevel extends Level 
{
    public function __construct()
    {
        parent::__construct();
        $this->promptText = "There are two portals in this room. One is glowing red while the other one is not glowing at all.";
        $this->items = [];
        $this->doors = ["Hell" => [0.25, 0.49],
                        "Elysium" => [0.75, 0.49]];
        $this->image = "Portals_DALL-E.webp";
        $this->backButton = true;
    }

    public function next($key=null, $heavenlyKey=null, $doorName=null): Level
    {
        if ($doorName == "Hell")
        {
            return new HellSceneLevel();
        } else {
            return new HeavenSceneLevel();
        }
    }


    public function previous(): Level
    {
        return new HatchLevel();
    }

    public function checkCoord(float $xCoord, float $yCoord): string
    {

        $doorTolerance = 0.5;
        foreach($this->doors as $item => $value) {
            $lowerX = $value[0] - 0.25; 
            $lowerY = $value[1] * (1- $doorTolerance);
            $higherX = $value[0] + 0.25;
            $higherY = $value[1] * (1 + $doorTolerance);
            if ( ($lowerX <= $xCoord && $xCoord < $higherX) && 
                 ($lowerY <= $yCoord && $yCoord <= $higherY) )
                 {
                    return $item;
                 }
        }
        return "Nothing happened";
    }

}
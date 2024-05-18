<?php


namespace App\Proj;

Class HellSceneLevel extends Level 
{
    public function __construct()
    {
        parent::__construct();
        $this->promptText = "You went to hell! So many years of search".
        " and struggle wasted because you entered the wrong portal.".
        " Click anywhere on the game screen to go back to the beginning";

        $this->items = [];
        $this->doors = [];
        $this->image = "Hell_DALL-E.webp";
        $this->backButton = false;
    }

    public function next($key=null, $heavenlyKey=null, $doorName=null): Level
    {
        return new EntryLevel();
    }


    public function previous(): Level
    {
        return new HellSceneLevel();
    }

    public function checkCoord(float $xCoord, float $yCoord): string
    {
        return "Restart";

    }

}
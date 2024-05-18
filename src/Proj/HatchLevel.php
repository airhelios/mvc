<?php


namespace App\Proj;

use App\Proj\EntryLevel;

/**
 * @property string $promptText The scene text
 * @property array $consideredAnswers All answers that will merit a custom response
 * @property string $imagePath Path to the image of the level.
 */
Class HatchLevel extends Level 
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

    public function next($key, $heavenlyKey): Level
    {
        

    }


    public function getBack(): Level
    {
        return new EntryLevel();
    }

}
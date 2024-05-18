<?php


namespace App\Proj;

use App\Proj\EntryLevel;
use App\Proj\HellPortalLevel;

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

    public function next($key, $heavenlyKey, $doorName=null): Level
    {

        if ($heavenlyKey && $key) {
            $next = new HatchLevel();
            $next->setPrompt("Going to heaven");
            return $next;
        } elseif ($key) {
            $next = new HellPortalLevel();
            return $next;
        } else {
            $next = new HatchLevel();
            $next->setPrompt("The door is locked, you need a key to open it");
            return $next;
        }
    }


    public function previous(): Level
    {
        return new EntryLevel();
    }

}
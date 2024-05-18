<?php

namespace App\Proj;

/**
 * @property string $promptText The scene text
 * @property array $consideredAnswers All answers that will merit a custom response
 * @property string $imagePath Path to the image of the level.
 */
abstract Class Level
{




    protected string $promptText;
    protected array $items;
    protected array $doors;
    protected string $image;
    protected bool $backButton;

    public function __construct()
    {
        $this->promptText = "";
        $this->items = [];
        $this->doors = [];
        $this->image = "";
        $this->backButton = true;
    }


    public function getImage(): string
    {
        return $this->image;
    }

    public function backButtonExists(): bool
    {
        return $this->backButton;
    }

    public function getPrompt(): string
    {
        return $this->promptText;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems($items): void
    {
        $this->items = $items;
    }

    public function getDoors(): array
    {
        return $this->doors;
    }

    public function setDoors($doors): void
    {
        $this->doors = $doors;
    }

    public function checkCoord(float $xCoord, float $yCoord): string
    {
        $itemTolerance = 0.05;
        foreach($this->items as $item => $value) {
            $lowerX = $value[0] * (1 - $itemTolerance); 
            $lowerY = $value[1] * (1- $itemTolerance);
            $higherX = $value[0] * (1 + $itemTolerance);
            $higherY = $value[1] * (1 + $itemTolerance);
            if ( ($lowerX <= $xCoord && $xCoord<= $higherX) && 
                 ($lowerY <= $yCoord && $yCoord <= $higherY) )
                 {
                    return $value[2];
                 }
        }
        $doorTolerance = 0.10;
        foreach($this->doors as $item => $value) {
            $lowerX = $value[0] * (1 - $doorTolerance); 
            $lowerY = $value[1] * (1- $doorTolerance);
            $higherX = $value[0] * (1 + $doorTolerance);
            $higherY = $value[1] * (1 + $doorTolerance);
            if ( ($lowerX <= $xCoord && $xCoord<= $higherX) && 
                 ($lowerY <= $yCoord && $yCoord <= $higherY) )
                 {
                    return $item;
                 }
        }
        return "Nothing happened";
    }

}
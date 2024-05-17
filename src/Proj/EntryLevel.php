<?php

namespace App\Proj;

/**
 * @property string $promptText The scene text
 * @property array $consideredAnswers All answers that will merit a custom response
 * @property string $imagePath Path to the image of the level.
 */
Class EntryLevel
{


    // private string $promptText = "After years of adventuring and searching you have finally found a way out of this forsaken world." .
    //                 " You are certain that the portal to Elysium is in this house. You just need find it.";

    // private array $items = ["Key" => [549/679, 550/679, "a key"],
    //                         "Heavenly_Key" => [763/1024, 586/1024, "the Heavenly Key"]];
    // private array $doors = ["Hatch" => [514/1024, 762/1024]];
    // private string $image = "Room_DALL-E.webp";

    private string $promptText;
    private array $items;
    private array $doors;
    private string $image;

    public function __construct(string $promptText, array $items, array $doors, string $image)
    {
        $this->promptText = $promptText;
        $this->items = $items;
        $this->doors = $doors;
        $this->image = $image;
    }


    public function getImage(): string
    {
        return $this->image;
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
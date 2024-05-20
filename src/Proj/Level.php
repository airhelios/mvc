<?php

namespace App\Proj;

/**
 * Suppress all rules containing "CyclomaticComplexity" in this
 * class
 *
 * @SuppressWarnings("CyclomaticComplexity")
    * @param array<string> $items
 */
abstract class Level
{
    protected string $promptText;

    /** @var array<mixed> */
    protected array $items;

    /** @var array<mixed> */
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

    public function setPrompt(string $text): void
    {
        $this->promptText = $text;
    }

    /**
    * @return string[]
    */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
    * @param string[] $items
    */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
    * @return string[]
    */
    public function getDoors(): array
    {
        return $this->doors;
    }

    /**
    * @param string[] $doors
    */
    public function setDoors(array $doors): void
    {
        $this->doors = $doors;
    }

    abstract public function previous(): Level;


    abstract public function next(?bool $key, ?bool $heavenlyKey, ?string $doorName): Level;



    public function checkCoord(float $xCoord, float $yCoord): string
    {
        $itemTolerance = 0.05;
        foreach($this->items as $item => $value) {
            $lowerX = $value[0] * (1 - $itemTolerance);
            $lowerY = $value[1] * (1 - $itemTolerance);
            $higherX = $value[0] * (1 + $itemTolerance);
            $higherY = $value[1] * (1 + $itemTolerance);
            if (($lowerX <= $xCoord && $xCoord <= $higherX) &&
                 ($lowerY <= $yCoord && $yCoord <= $higherY)) {
                return $value[2];
            }
        }
        $doorTolerance = 0.10;
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

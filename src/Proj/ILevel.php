<?php

namespace App\Proj;

/**
 * @property string $promptText The scene text
 * @property array $itemsAll answers that will merit a custom response
 * @property string $imagePath Path to the image of the level.
 */
interface ILevel
{
    public function checkResponse(string $value): bool;
    public function getResponse(string $answer): string;
}

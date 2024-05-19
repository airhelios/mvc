<?php

namespace App\Proj;

class EntryLevel extends Level
{
    public function __construct()
    {
        parent::__construct();
        $this->promptText = "After years of adventuring and searching you have finally found a way out of this forsaken world." .
        " You are certain that the portal to Elysium is in this house. You just need find it.";
        $this->items = ["Key" => [549 / 679, 550 / 679, "key"],
        "Heavenly_Key" => [763 / 1024, 586 / 1024, "heavenly_key"]];
        $this->doors = ["Hatch" => [514 / 1024, 762 / 1024]];
        $this->image = "Room_DALL-E.webp";
        $this->backButton = false;
    }

    public function next($key = null, $heavenlyKey = null, $doorName = null): Level
    {
        return new HatchLevel();
    }

    public function previous(): Level
    {
        return new EntryLevel();
    }

}

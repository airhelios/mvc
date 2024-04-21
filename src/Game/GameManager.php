<?php

namespace App\Game;
class GameManager
{
    protected $playerHand;
    protected $machineHand;
    protected $deck;

    
    public function __construct($playerHand, $machineHand, $deck)
    {
        $this->$playerHand = $playerHand;
        $this->$machineHand = $machineHand;
        $this->deck = $deck;
    }

    

}

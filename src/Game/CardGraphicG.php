<?php

namespace App\Game;

class CardGraphicG extends CardG
{

    private $representation = [
        '🂡','🂢','🂣','🂤','🂥','🂦','🂧','🂨','🂩','🂪','🂫','🂭','🂮',
        '🂱','🂲','🂳','🂴','🂵','🂶','🂷','🂸','🂹','🂺','🂻','🂽','🂾',
        '🃁','🃂','🃃','🃄','🃅','🃆','🃇','🃈','🃉','🃊','🃋','🃍','🃎',
        '🃑','🃒','🃓','🃔','🃕','🃖','🃗','🃘','🃙','🃚','🃛','🃝','🃞'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAsString(): string
    {
        return  $this->representation[$this->value - 1 + $this->color*13];
    }

}

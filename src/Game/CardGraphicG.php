<?php

namespace App\Game;

class CardGraphicG extends CardG
{
    
    /**
     * @var string[]
     */
    private array $representation = [
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
        return  $this->representation[$this->value - 1 + $this->color * 13];
    }

    public function getAsStringParent(): string
    {
        return parent::getAsString();
    }

}

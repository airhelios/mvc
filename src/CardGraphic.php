<?php

namespace App\Card;

class CardGraphic extends Card
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
        return  $this->representation[$this->value];
    }

}

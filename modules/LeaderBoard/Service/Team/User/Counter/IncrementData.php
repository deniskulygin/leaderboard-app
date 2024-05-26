<?php
declare(strict_types = 1);

namespace LeaderBoard\Service\Team\User\Counter;

use LeaderBoard\ORM\Model\TeamUserCounter;

class IncrementData
{
    public function __construct(private readonly TeamUserCounter $teamUserCounter, private readonly int $increment)
    {

    }

    public function getTeamUserCounter(): TeamUserCounter
    {
        return $this->teamUserCounter;
    }

    public function getIncrement(): int
    {
        return $this->increment;
    }
}

<?php
declare(strict_types = 1);

namespace LeaderBoard\Service\Team;

use LeaderBoard\ORM\Model\User;

class CreateData
{
    public function __construct(private readonly string $teamName)
    {
    }

    public function getTeamName(): string
    {
        return $this->teamName;
    }
}

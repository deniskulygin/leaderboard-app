<?php
declare(strict_types = 1);

namespace LeaderBoard\Service\Team\User;

use LeaderBoard\ORM\Model\Team;
use LeaderBoard\ORM\Model\User;

class CreateData
{
    public function __construct(private readonly User $user, private readonly Team $team)
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }
}

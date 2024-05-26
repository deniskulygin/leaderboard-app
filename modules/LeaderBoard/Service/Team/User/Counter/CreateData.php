<?php
declare(strict_types = 1);

namespace LeaderBoard\Service\Team\User\Counter;

use LeaderBoard\ORM\Model\TeamUser;
use LeaderBoard\ORM\Model\User;

class CreateData
{
    public function __construct(private readonly User $user, private readonly TeamUser $teamUser)
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getTeamUser(): TeamUser
    {
        return $this->teamUser;
    }
}

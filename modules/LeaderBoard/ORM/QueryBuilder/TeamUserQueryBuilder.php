<?php
declare(strict_types = 1);

namespace LeaderBoard\ORM\QueryBuilder;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use LeaderBoard\ORM\Model\Team;
use LeaderBoard\ORM\Model\TeamUser;
use LeaderBoard\ORM\Model\User;

class TeamUserQueryBuilder extends EloquentBuilder
{
    public function isUserInTeam(User $user, Team $team): bool
    {
        return $this->where('user_id', '=', $user->getId())
            ->where('team_id', '=', $team->getId())
            ->exists();
    }

    public function isUserTeamAdmInTeam(User $user, Team $team): bool
    {
        return $this->where('user_id', '=', $user->getId())
            ->where('team_id', '=', $team->getId())
            ->where('role', '=', TeamUser::ROLE_ADMIN)
            ->exists();
    }
}

<?php
declare(strict_types = 1);

namespace LeaderBoard\ORM\QueryBuilder;


use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use LeaderBoard\ORM\Model\Team;
use LeaderBoard\ORM\Model\TeamUser;
use LeaderBoard\ORM\Model\TeamUserCounter;
use LeaderBoard\ORM\Model\User;

class TeamUserCounterQueryBuilder extends EloquentBuilder
{
    public function ofUserTeam(User $user, Team $team): EloquentBuilder
    {
        return $this
            ->select(TeamUserCounter::TABLE_NAME . '.*')
            ->join(
                TeamUser::TABLE_NAME,
                TeamUser::TABLE_NAME . '.id',
                '=',
                TeamUserCounter::TABLE_NAME . '.team_user_id'
            )
            ->where(TeamUser::TABLE_NAME . '.team_id', '=', $team->getId())
            ->where(TeamUser::TABLE_NAME . '.user_id', '=', $user->getId());
    }
}

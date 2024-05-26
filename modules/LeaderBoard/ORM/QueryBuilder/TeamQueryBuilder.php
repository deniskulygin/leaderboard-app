<?php
declare(strict_types = 1);

namespace LeaderBoard\ORM\QueryBuilder;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use LeaderBoard\ORM\Model\Team;
use LeaderBoard\ORM\Model\TeamUser;
use LeaderBoard\ORM\Model\User;

class TeamQueryBuilder extends EloquentBuilder
{
    public function getUserTeams(User $user): EloquentBuilder
    {
        return $this
            ->select(Team::TABLE_NAME . '.*')
            ->join(
                TeamUser::TABLE_NAME,
                TeamUser::TABLE_NAME . '.team_id',
                '=',
                Team::TABLE_NAME . '.id'
            )
            ->where(TeamUser::TABLE_NAME . '.user_id', '=', $user->getId());
    }
}

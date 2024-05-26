<?php
declare(strict_types = 1);

namespace LeaderBoard\ORM\Repository;

use Illuminate\Database\Eloquent\Model;
use LeaderBoard\ORM\Model\Team;
use LeaderBoard\ORM\Model\TeamUser;
use LeaderBoard\ORM\Model\TeamUserCounter;
use LeaderBoard\ORM\Model\User;

class TeamUserCounterRepository extends BaseRepository
{
    /**
     * @return TeamUserCounter|Model|null
     */
    public function findByUniqueId(User $user, string $teamUid, string $counterUId): ?TeamUserCounter
    {
        return $this->getModel()
            ->newQuery()
            ->select(TeamUserCounter::TABLE_NAME . '.*')
            ->join(
                TeamUser::TABLE_NAME,
                TeamUser::TABLE_NAME . '.id',
                '=',
                TeamUserCounter::TABLE_NAME . '.team_user_id'
            )
            ->join(
                Team::TABLE_NAME,
                Team::TABLE_NAME . '.id',
                '=',
                TeamUser::TABLE_NAME . '.team_id'
            )
            ->where(Team::TABLE_NAME . '.unique_id', '=', $teamUid)
            ->where(TeamUserCounter::TABLE_NAME . '.unique_id', '=', $counterUId)
            ->where(TeamUser::TABLE_NAME . '.user_id', '=', $user->getId())
            ->first();
    }

    public function hasTeamUser(TeamUser $teamUser): bool
    {
        return $this->getModel()
            ->newQuery()
            ->where(TeamUserCounter::TABLE_NAME . '.team_user_id', '=', $teamUser->getId())
            ->exists();
    }
}

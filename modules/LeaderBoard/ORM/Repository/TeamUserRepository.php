<?php
declare(strict_types = 1);

namespace LeaderBoard\ORM\Repository;

use Illuminate\Database\Eloquent\Model;
use LeaderBoard\ORM\Model\Team;
use LeaderBoard\ORM\Model\TeamUser;
use LeaderBoard\ORM\Model\User;

class TeamUserRepository extends BaseRepository
{
    /**
     * @return TeamUser|Model|null
     */
    public function findByUniqueId(User $user, string $teamUid): ?TeamUser
    {
        return $this->getModel()
            ->newQuery()
            ->join(
                Team::TABLE_NAME,
                Team::TABLE_NAME . '.id',
                '=',
                TeamUser::TABLE_NAME . '.team_id'
            )
            ->where(Team::TABLE_NAME . '.unique_id', '=', $teamUid)
            ->where(TeamUser::TABLE_NAME . '.user_id', '=', $user->getId())
            ->first();
    }
}

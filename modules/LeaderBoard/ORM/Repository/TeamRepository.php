<?php
declare(strict_types = 1);

namespace LeaderBoard\ORM\Repository;

use Illuminate\Database\Eloquent\Model;
use LeaderBoard\ORM\Model\Team;

class TeamRepository extends BaseRepository
{
    /**
     * @return Team|Model|null
     */
    public function findByUniqueId(string $teamUid): ?Team
    {
        return $this->getModel()
            ->newQuery()
            ->where('unique_id', '=', $teamUid)
            ->first();
    }
}

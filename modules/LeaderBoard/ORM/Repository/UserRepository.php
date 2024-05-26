<?php
declare(strict_types = 1);

namespace LeaderBoard\ORM\Repository;

use Illuminate\Database\Eloquent\Model;
use LeaderBoard\ORM\Model\User;

class UserRepository extends BaseRepository
{
    /**
     * @return User|Model|null
     */
    public function findByUniqueId(string $teamUid): ?User
    {
        return $this->getModel()
            ->newQuery()
            ->where('unique_id', '=', $teamUid)
            ->first();
    }
}

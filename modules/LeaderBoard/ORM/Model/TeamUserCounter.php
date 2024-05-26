<?php
declare(strict_types = 1);

namespace LeaderBoard\ORM\Model;

use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use LeaderBoard\ORM\QueryBuilder\TeamUserCounterQueryBuilder;

/**
 * @method int getId()
 * @method string getUniqueId()
 * @method int getTeamUserId()
 * @method $this setTeamUserId(int $teamId)
 * @method int getCount()
 * @method $this setCount(int $count)
 * @method int setCreatedAt(int $createdAt)
 * @method int getCreatedAt()
 * @method int setUpdatedAt(int $updatedAt)
 * @method int|null getUpdatedAt()
 *
 * @method static TeamUserCounterQueryBuilder query()
 */
class TeamUserCounter extends AbstractModel
{
    public const TABLE_NAME = 'team_user_counters';

    protected function init(): void
    {
        $this->table = self::TABLE_NAME;
        $this->dateFormat = 'U';
        $this->casts = [
            'created_at' => 'timestamp',
            'updated_at' => 'timestamp',
        ];
    }

    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            TeamUser::class,
            'id',
            'id',
            'team_user_id',
            'user_id',
        );
    }

    public function getUser(): User
    {
        return $this->getRelationValue('user');
    }

    public function newEloquentBuilder($query): TeamUserCounterQueryBuilder
    {
        return new TeamUserCounterQueryBuilder($query);
    }
}

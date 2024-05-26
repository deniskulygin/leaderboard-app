<?php
declare(strict_types = 1);

namespace LeaderBoard\ORM\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use LeaderBoard\ORM\QueryBuilder\TeamQueryBuilder;

/**
 * @method int getId()
 * @method string getUniqueId()
 * @method string getName()
 * @method $this setName(string $name)
 * @method int setCreatedAt(int $createdAt)
 * @method int getCreatedAt()
 * @method int setUpdatedAt(int $updatedAt)
 * @method int|null getUpdatedAt()
 *
 * @method static TeamQueryBuilder query()
 */
class Team extends AbstractModel
{
    public const TABLE_NAME = 'teams';

    protected function init(): void
    {
        $this->table = self::TABLE_NAME;
        $this->dateFormat = 'U';
        $this->casts = [
            'created_at' => 'timestamp',
            'updated_at' => 'timestamp',
        ];
    }

    public function newEloquentBuilder($query): TeamQueryBuilder
    {
        return new TeamQueryBuilder($query);
    }

    public function counter(): HasManyThrough
    {
        return $this->hasManyThrough(
            TeamUserCounter::class,
            TeamUser::class,
            'team_id',
            'team_user_id',
            'id',
            'id',
        );
    }

    public function getTotalCounter(): int
    {
        return (int) $this->counter()->sum(TeamUserCounter::TABLE_NAME . '.count');
    }
}

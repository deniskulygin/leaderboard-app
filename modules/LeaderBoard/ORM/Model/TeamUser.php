<?php
declare(strict_types = 1);

namespace LeaderBoard\ORM\Model;

use LeaderBoard\ORM\QueryBuilder\TeamUserQueryBuilder;

/**
 * @method int getId()
 * @method int getTeamId()
 * @method $this setTeamId(int $teamId)
 * @method int getUserId()
 * @method $this setUserId(int $teamId)
 * @method int setCreatedAt(int $createdAt)
 * @method int getCreatedAt()
 *
 * @method static TeamUserQueryBuilder query()
 */
class TeamUser extends AbstractModel
{
    public const ROLE_ADMIN = 1;

    public const TABLE_NAME = 'team_users';
    public const UNIQUE_ID = null;
    public const UPDATED_AT = null;

    protected function init(): void
    {
        $this->table = self::TABLE_NAME;
        $this->dateFormat = 'U';
        $this->casts = [
            'created_at' => 'timestamp',
        ];
    }

    public function newEloquentBuilder($query): TeamUserQueryBuilder
    {
        return new TeamUserQueryBuilder($query);
    }
}

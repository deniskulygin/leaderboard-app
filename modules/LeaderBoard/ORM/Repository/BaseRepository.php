<?php
declare(strict_types = 1);

namespace LeaderBoard\ORM\Repository;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    public function __construct(private readonly Model $model, ?string $connectionName = null)
    {
        if (null !== $connectionName) {
            $model->setConnection($connectionName);
        }
    }

    /**
     * @param int $id
     *
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->getModel()->find($id);
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }
}

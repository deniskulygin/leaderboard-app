<?php
declare(strict_types = 1);

namespace LeaderBoard\ORM\Manager;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use LeaderBoard\ORM\Model\TeamUserCounter;
use LeaderBoard\Service\Team\User\Counter\CreateData;
use LeaderBoard\Service\Team\User\Counter\IncrementData;

class TeamUserCounterManager
{
    public function __construct(private readonly Container $container)
    {
    }

    /**
     * @throws BindingResolutionException
     */
    public function create(CreateData $data): TeamUserCounter
    {
        $teamUserCounter = $this->getModel();

        $teamUserCounter->setTeamUserId($data->getTeamUser()->getId())->save();

        return $teamUserCounter;
    }

    public function delete(TeamUserCounter $teamUserCounter): bool
    {
        return $teamUserCounter->delete();
    }

    /**
     * @throws \Throwable
     */
    public function increment(IncrementData $data): bool
    {
        $connection = $data->getTeamUserCounter()->getConnection();

        $connection->beginTransaction();

        try {
            /** @var TeamUserCounter $lockedModel */
            $lockedModel =
                TeamUserCounter::query()->lockForUpdate()->find($data->getTeamUserCounter()->getId());
            $lockedModel = $lockedModel->setCount($lockedModel->getCount() + $data->getIncrement())->save();
        } catch (\Throwable ) {
            $connection->rollBack();
            throw new \LogicException();
        }

        $connection->commit();

        return $lockedModel;
    }

    /**
     * @throws BindingResolutionException
     */
    private function getModel(): TeamUserCounter
    {
        return $this->container->make(TeamUserCounter::class);
    }
}

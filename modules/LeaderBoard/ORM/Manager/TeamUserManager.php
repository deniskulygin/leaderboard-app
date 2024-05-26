<?php
declare(strict_types = 1);

namespace LeaderBoard\ORM\Manager;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use LeaderBoard\ORM\Model\TeamUser;
use LeaderBoard\Service\Team\User\CreateData;
use LeaderBoard\Service\Team\User\DeleteData;

class TeamUserManager
{
    public function __construct(private readonly Container $container)
    {
    }
    /**
     * @throws BindingResolutionException
     */
    public function create(CreateData $data): TeamUser
    {
        $teamUserModel = $this->getModel();

        $teamUserModel->setUserId($data->getUser()->getId())
            ->setTeamId($data->getTeam()->getId())
            ->save();

        return $teamUserModel;
    }

    /**
     * @throws BindingResolutionException
     */
    public function delete(DeleteData $data): int
    {
        $teamUserModel = $this->getModel();

        return $teamUserModel->newQuery()
            ->where('user_id', '=', $data->getUser()->getId())
            ->where('team_id', '=', $data->getTeam()->getId())
            ->delete();
    }

    /**
     * @throws BindingResolutionException
     */
    private function getModel(): TeamUser
    {
        return $this->container->make(TeamUser::class);
    }
}

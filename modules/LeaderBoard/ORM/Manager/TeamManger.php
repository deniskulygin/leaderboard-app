<?php
declare(strict_types = 1);

namespace LeaderBoard\ORM\Manager;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use LeaderBoard\ORM\Model\Team;
use LeaderBoard\Service\Team\CreateData;

class TeamManger
{
    public function __construct(private readonly Container $container)
    {
    }

    /**
     * @throws BindingResolutionException
     */
    public function create(CreateData $data): Team
    {
        $team = $this->getModel();

        $team->setName($data->getTeamName())->save();

        return $team;
    }

    public function delete(Team $team): bool
    {
        return $team->delete();
    }

    /**
     * @throws BindingResolutionException
     */
    private function getModel(): Team
    {
        return $this->container->make(Team::class);
    }
}

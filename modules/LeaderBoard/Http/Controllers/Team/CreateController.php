<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Controllers\Team;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Response;
use LeaderBoard\Http\Request\Team\CreateRequest;
use LeaderBoard\ORM\Manager\TeamManger;
use LeaderBoard\ORM\Manager\TeamUserManager;
use LeaderBoard\Service\Team\CreateData as TeamCreateData;
use LeaderBoard\Service\Team\User\CreateData;

class CreateController
{
    public function __construct(
        private readonly TeamManger $teamManger,
        private readonly TeamUserManager $teamUserManager
    )
    {
    }

    /**
     * @throws BindingResolutionException
     */
    public function __invoke(CreateRequest $request): Response
    {
        $team = $this->teamManger->create(new TeamCreateData($request->getName()));
        $this->teamUserManager->create(new CreateData($request->user(), $team));

        return new Response(['id' => $team->getUniqueId()], 201);
    }
}

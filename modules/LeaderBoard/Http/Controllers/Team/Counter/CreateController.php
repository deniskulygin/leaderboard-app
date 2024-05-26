<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Controllers\Team\Counter;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Response;
use LeaderBoard\Exception\ApiException;
use LeaderBoard\Http\Request\Team\Counter\CreateRequest;
use LeaderBoard\ORM\Manager\TeamUserCounterManager;
use LeaderBoard\ORM\Model\TeamUser;
use LeaderBoard\ORM\Repository\TeamUserCounterRepository;
use LeaderBoard\ORM\Repository\TeamUserRepository;
use LeaderBoard\Service\Team\User\Counter\CreateData;

class CreateController
{
    public function __construct(
        private readonly TeamUserCounterManager $teamUserCounterManager,
        private readonly TeamUserRepository $teamUserRepository,
        private readonly TeamUserCounterRepository $teamUserCounterRepository
    ) {
    }

    /**
     * @throws BindingResolutionException
     * @throws ApiException
     */
    public function __invoke(CreateRequest $request): Response
    {
        /** @var TeamUser $teamUser */
        $teamUser = $this->teamUserRepository->findByUniqueId($request->user(), $request->getTeamId());
        $teamUserCounterExist = $this->teamUserCounterRepository->hasTeamUser($teamUser);

        if (true === $teamUserCounterExist) {
            throw new ApiException('User has counter in this team');
        }
        $teamUserCounter = $this->teamUserCounterManager->create(new CreateData($request->user(), $teamUser));

        return new Response(['id' => $teamUserCounter->getUniqueId()], 201);
    }
}

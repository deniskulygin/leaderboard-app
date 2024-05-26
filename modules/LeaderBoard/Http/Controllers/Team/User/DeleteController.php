<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Controllers\Team\User;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Response;
use LeaderBoard\Http\Request\Team\User\DeleteRequest;
use LeaderBoard\ORM\Manager\TeamUserManager;
use LeaderBoard\ORM\Repository\TeamRepository;
use LeaderBoard\ORM\Repository\UserRepository;
use LeaderBoard\Service\Team\User\DeleteData;

class DeleteController
{
    public function __construct(
        private readonly TeamUserManager $teamUserManager,
        private readonly TeamRepository $teamRepository,
        private readonly UserRepository $userRepository
    ) {
    }

    /**
     * @throws BindingResolutionException
     */
    public function __invoke(DeleteRequest $request)
    {
        $team = $this->teamRepository->findByUniqueId($request->getTeamId());
        $user = $this->userRepository->findByUniqueId($request->getUserId());

        $this->teamUserManager->delete(new DeleteData($user, $team));

        return new Response(null, 204);
    }
}

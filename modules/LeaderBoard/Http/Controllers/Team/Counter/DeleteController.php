<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Controllers\Team\Counter;

use Illuminate\Http\Response;
use LeaderBoard\Exception\EntityNotFoundException;
use LeaderBoard\Http\Request\Team\Counter\DeleteRequest;
use LeaderBoard\ORM\Manager\TeamUserCounterManager;
use LeaderBoard\ORM\Repository\TeamUserCounterRepository;

class DeleteController
{
    public function __construct(
        private readonly TeamUserCounterManager $teamUserCounterManger,
        private readonly TeamUserCounterRepository $teamUserCounterRepository
    ) {
    }

    /**
     * @throws EntityNotFoundException
     */
    public function __invoke(DeleteRequest $request): Response
    {
        $teamUserCounter = $this->teamUserCounterRepository->findByUniqueId(
            $request->user(),
            $request->getTeamId(),
            $request->getCounterId()
        );

        if (null === $teamUserCounter) {
            throw new EntityNotFoundException('Counter not exists');
        }

        $this->teamUserCounterManger->delete($teamUserCounter);

        return new Response(null, 204);
    }
}

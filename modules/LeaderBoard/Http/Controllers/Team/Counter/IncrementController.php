<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Controllers\Team\Counter;

use Illuminate\Http\Response;
use LeaderBoard\Exception\ApiException;
use LeaderBoard\Exception\EntityNotFoundException;
use LeaderBoard\Http\Request\Team\Counter\IncrementRequest;
use LeaderBoard\ORM\Manager\TeamUserCounterManager;
use LeaderBoard\ORM\Repository\TeamUserCounterRepository;
use LeaderBoard\Service\Team\User\Counter\IncrementData;

class IncrementController
{
    public function __construct(
        private readonly TeamUserCounterManager $teamUserCounterManger,
        private readonly TeamUserCounterRepository $teamUserCounterRepository
    ) {
    }

    /**
     * @throws EntityNotFoundException
     * @throws ApiException|\Throwable
     */
    public function __invoke(IncrementRequest $request): Response
    {
        $teamUserCounter = $this->teamUserCounterRepository->findByUniqueId(
            $request->user(),
            $request->getTeamId(),
            $request->getCounterId()
        );

        if (null === $teamUserCounter) {
            throw new EntityNotFoundException('Counter not exists');
        }

        try {
            $this->teamUserCounterManger->increment(new IncrementData($teamUserCounter, $request->getIncrement()));
        } catch (\LogicException) {
            throw new ApiException('Cannot increment');
        }

        return new Response(null, 204);
    }
}

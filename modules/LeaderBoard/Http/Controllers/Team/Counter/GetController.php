<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Controllers\Team\Counter;

use Illuminate\Http\Response;
use LeaderBoard\Exception\EntityNotFoundException;
use LeaderBoard\Http\Request\Team\Counter\GetRequest;
use LeaderBoard\Http\Response\ResponseFactory;
use LeaderBoard\Http\Response\Transformer\TeamUserCounterTransformer;
use LeaderBoard\ORM\Repository\TeamUserCounterRepository;

class GetController
{
    public function __construct(
        private readonly TeamUserCounterRepository $teamUserCounterRepository,
        private readonly ResponseFactory $responseFactory
    ) {
    }

    /**
     * @throws EntityNotFoundException
     */
    public function __invoke(GetRequest $request): Response
    {
        $teamUserCounter = $this->teamUserCounterRepository->findByUniqueId(
            $request->user(),
            $request->getTeamId(),
            $request->getCounterId()
        );

        if (null === $teamUserCounter) {
            throw new EntityNotFoundException('Counter not exists');
        }

        return $this->responseFactory->item($teamUserCounter, new TeamUserCounterTransformer());
    }
}

<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Controllers\Team\Counter;

use Illuminate\Http\Response;
use LeaderBoard\Entity\TeamEntityResolver;
use LeaderBoard\Exception\EntityNotFoundException;
use LeaderBoard\Http\Request\ListRequest;
use LeaderBoard\Http\Response\ResponseFactory;
use LeaderBoard\Http\Response\Transformer\TeamUserCounterTransformer;
use LeaderBoard\ORM\Model\TeamUserCounter;

class ListController
{
    public function __construct(
        private readonly TeamEntityResolver $teamEntityResolver,
        private readonly ResponseFactory $responseFactory
    ) {
    }

    /**
     * @throws EntityNotFoundException
     */
    public function __invoke(ListRequest $request): Response
    {
        $team = $this->teamEntityResolver->retrieveEntity($request->route()->parameters());
        $teamsUserCounterBuilder = TeamUserCounter::query()->ofUserTeam($request->user(), $team);

        return $this->responseFactory->collection(
            $teamsUserCounterBuilder->paginate($request->getPerPage()),
            new TeamUserCounterTransformer()
        );
    }
}

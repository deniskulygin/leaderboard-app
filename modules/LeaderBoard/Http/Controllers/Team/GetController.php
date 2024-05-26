<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Controllers\Team;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LeaderBoard\Entity\TeamEntityResolver;
use LeaderBoard\Exception\EntityNotFoundException;
use LeaderBoard\Http\Response\ResponseFactory;
use LeaderBoard\Http\Response\Transformer\TeamTransformer;

class GetController
{
    public function __construct(
        private readonly TeamEntityResolver $teamEntityResolver,
        private readonly ResponseFactory $responseFactory
    ) {
    }

    /**
     * @throws EntityNotFoundException
     */
    public function __invoke(Request $request): Response
    {
        $team = $this->teamEntityResolver->retrieveEntity($request->route()->parameters());

        return $this->responseFactory->item($team, new TeamTransformer());
    }
}

<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Controllers\Team;

use Illuminate\Http\Response;
use LeaderBoard\Http\Request\ListRequest;
use LeaderBoard\Http\Response\ResponseFactory;
use LeaderBoard\Http\Response\Transformer\TeamTransformer;
use LeaderBoard\ORM\Model\Team;

class ListController
{
    public function __construct(private readonly ResponseFactory $responseFactory) {
    }

    public function __invoke(ListRequest $request): Response
    {
        $teamsBuilder = Team::query()->getUserTeams($request->user());

        return $this->responseFactory->collection(
            $teamsBuilder->paginate($request->getPerPage()),
            new TeamTransformer()
        );
    }
}

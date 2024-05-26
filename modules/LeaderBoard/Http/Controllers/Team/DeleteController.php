<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Controllers\Team;

use Illuminate\Http\Response;
use LeaderBoard\Entity\TeamEntityResolver;
use LeaderBoard\Exception\EntityNotFoundException;
use LeaderBoard\Http\Request\Team\DeleteRequest;
use LeaderBoard\ORM\Manager\TeamManger;

class DeleteController
{
    public function __construct(
        private readonly TeamEntityResolver $teamEntityResolver,
        private readonly TeamManger $teamManger,
    ) {
    }

    /**
     * @throws EntityNotFoundException
     */
    public function __invoke(DeleteRequest $request): Response
    {
        $team = $this->teamEntityResolver->retrieveEntity($request->route()->parameters());
        $this->teamManger->delete($team);

        return new Response(null, 204);
    }
}

<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Middleware;

use Illuminate\Http\Request;
use LeaderBoard\Exception\ApiException;
use LeaderBoard\ORM\Model\TeamUser;
use LeaderBoard\ORM\Repository\TeamRepository;

class TeamUserMiddleware
{
    public function __construct(private readonly TeamRepository $teamRepository)
    {
    }

    /**
     * @throws ApiException
     */
    public function handle(Request $request, \Closure $next)
    {
        $team = $this->teamRepository->findByUniqueId($request->route('teamUniqueId'));

        $userIsTeamAdmin = TeamUser::query()->isUserTeamAdmInTeam($request->user(), $team);

        if (false === $userIsTeamAdmin) {
            throw new ApiException('User is not part of the team');
        }

        return $next($request);
    }
}

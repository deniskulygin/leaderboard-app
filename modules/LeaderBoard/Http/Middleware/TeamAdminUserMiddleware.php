<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Middleware;

use Illuminate\Http\Request;
use LeaderBoard\Exception\EntityNotFoundException;
use LeaderBoard\ORM\Model\TeamUser;
use LeaderBoard\ORM\Repository\TeamRepository;

class TeamAdminUserMiddleware
{
    public function __construct(private readonly TeamRepository $teamRepository)
    {
    }

    /**
     * @throws EntityNotFoundException
     */
    public function handle(Request $request, \Closure $next)
    {
        $team = $this->teamRepository->findByUniqueId($request->route('teamUniqueId'));

        if (null === $team) {
            throw new EntityNotFoundException('Team not found');
        }

        $userIsTeamAdmin = TeamUser::query()->isUserTeamAdmInTeam($request->user(), $team);

        if (false === $userIsTeamAdmin) {
            throw new EntityNotFoundException('User is not team admin');
        }

        return $next($request);
    }
}

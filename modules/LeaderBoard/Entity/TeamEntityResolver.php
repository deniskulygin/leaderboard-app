<?php
declare(strict_types = 1);

namespace LeaderBoard\Entity;

use LeaderBoard\Exception\EntityNotFoundException;
use LeaderBoard\ORM\Model\Team;
use LeaderBoard\ORM\Repository\TeamRepository;

class TeamEntityResolver extends EntityResolver
{
    private const TEAM_UNIQUE_ID_PARAMETER = 'teamUniqueId';

    private ?Team $team = null;

    public function __construct(private readonly TeamRepository $teamRepository)
    {
    }

    /**
     * @throws EntityNotFoundException
     */
    public function retrieveEntity(array $parameters): Team
    {
        if ($this->team !== null) {
            return $this->team;
        }

        $uniqueId = $this->getParameter(self::TEAM_UNIQUE_ID_PARAMETER, $parameters);
        $team = $this->teamRepository->findByUniqueId($uniqueId);

        if ($team === null) {
            throw new EntityNotFoundException('Team not found');
        }

        $this->team = $team;

        return $team;
    }
}

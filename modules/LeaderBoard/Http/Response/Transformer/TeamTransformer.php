<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Response\Transformer;

use LeaderBoard\ORM\Model\Team;
use League\Fractal\TransformerAbstract;

class TeamTransformer extends TransformerAbstract
{
    public function transform(Team $team): array
    {
        return [
            'id' => $team->getUniqueId(),
            'name' => $team->getName(),
            'step_count' => $team->getTotalCounter(),
            'created' => $team->getCreatedAt(),
            'updated' => $team->getUpdatedAt(),
        ];
    }
}

<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Response\Transformer;

use LeaderBoard\ORM\Model\TeamUserCounter;
use League\Fractal\TransformerAbstract;

class TeamUserCounterTransformer extends TransformerAbstract
{
    public function transform(TeamUserCounter $teamUserCounter): array
    {
        return [
            'id' => $teamUserCounter->getUniqueId(),
            'user_id' => $teamUserCounter->getUser()->getUniqueId(),
            'steps_count' =>  $teamUserCounter->getCount(),
            'created' => $teamUserCounter->getCreatedAt(),
            'updated' => $teamUserCounter->getUpdatedAt()
        ];
    }
}

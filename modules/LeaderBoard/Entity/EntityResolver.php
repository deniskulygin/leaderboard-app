<?php
declare(strict_types = 1);

namespace LeaderBoard\Entity;

use Illuminate\Database\Eloquent\Model;

abstract class EntityResolver
{
    abstract public function retrieveEntity(array $parameters): Model;

    protected function getParameter(string $parameterName, array $parameters)
    {
        if (array_key_exists($parameterName, $parameters)) {
            return $parameters[$parameterName];
        }

        throw new \RuntimeException('Parameter was not found');
    }
}

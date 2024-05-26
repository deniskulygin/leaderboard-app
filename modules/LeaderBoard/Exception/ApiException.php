<?php
declare(strict_types = 1);

namespace LeaderBoard\Exception;

use Symfony\Component\HttpFoundation\Response;

class ApiException extends BaseException
{
    function getStatus(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}

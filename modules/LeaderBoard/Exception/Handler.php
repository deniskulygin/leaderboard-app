<?php
declare(strict_types = 1);

namespace LeaderBoard\Exception;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class Handler extends \Illuminate\Foundation\Exceptions\Handler
{
    protected function invalidJson($request, ValidationException $exception): JsonResponse
    {
        return response()->json([
            'errors' => [
                [
                    'message' => $exception->getMessage(),
                ],
            ],
        ], $exception->status);
    }
}

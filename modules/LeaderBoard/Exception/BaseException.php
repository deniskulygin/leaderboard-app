<?php
declare(strict_types = 1);

namespace LeaderBoard\Exception;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseException extends \Exception
{
    public function __construct(string $message, int $code = 0)
    {
        parent::__construct($message, $code);
    }

    public function render(Request $request): Response
    {
        $response = [
            'errors' => [
                [
                    'message' => $this->getMessage(),
                ],
            ],
        ];

        if (config('app.debug')) {
            $response = $this->debugResponse();
        }

        return new JsonResponse(
            $response,
            $this->getStatus(),
            [
                'Status' =>
                    sprintf(
                        '%s %s',
                        $this->getStatus(),
                        Response::$statusTexts[$this->getStatus()]
                    ),
            ]
        );
    }

    public function debugResponse(): array
    {
        return ['_debug' => [
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'exception' => \get_class($this),
            'file' => $this->getFile(),
            'line' => $this->getLine(),
            'trace' => collect($this->getTrace())->map(
                function ($trace) {
                    return Arr::except($trace, ['args', 'type']);
                }
            )->all(),
        ]];
    }

    abstract function getStatus(): int;
}

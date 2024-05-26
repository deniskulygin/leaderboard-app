<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Request\Team\Counter;

use LeaderBoard\Http\Request\JsonFormRequest;

class IncrementRequest extends JsonFormRequest
{
    private const DEFAULT_INCREMENT = 1;

    public function rules(): array
    {
        return [
            'increment' => 'integer|min:1|between: 1,1000',
        ];
    }

    public function messages(): array
    {
        return [
            'increment.integer' => 'Field increment must be an integer',
            'increment.min' => 'Field increment must be greater then 1',
            'increment.digits_between' => 'must be a integer between 1 to 1000',
        ];
    }

    public function getIncrement(): int
    {
        return $this->json('increment') ?: self::DEFAULT_INCREMENT;
    }

    public function getTeamId(): string
    {
        return $this->route('teamUniqueId');
    }

    public function getCounterId(): string
    {
        return $this->route('counterUniqueId');
    }
}

<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Request\Team;

use LeaderBoard\Http\Request\JsonFormRequest;

class CreateRequest extends JsonFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'bail|required|string|max:40'
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'Field name must be a string',
            'name.required' => 'Field name is required',
            'name.max' => 'Field name cannot be longer than 40 characters',
        ];
    }

    public function getName(): string
    {
        return $this->json('name');
    }
}

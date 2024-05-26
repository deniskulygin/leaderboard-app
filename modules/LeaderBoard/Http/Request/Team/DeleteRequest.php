<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Request\Team;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'team_id' => 'bail|required|regex:"[a-z0-9]{40}"|exists:LeaderBoard\ORM\Model\Team,unique_id'
        ];
    }

    public function messages()
    {
        return [
            'team_id.string' => 'Field team_id must be a string',
            'team_id.required' => 'Field team_id is required',
            'team_id.max' => 'Field team_id cannot be longer than 40 characters',
            'team_id.regex' => 'Field team_id is not appropriate',
            'team_id.exists' => 'Team is not exist',
        ];
    }

    public function all($keys = null): array
    {
        $data = parent::all();
        $data['team_id'] = $this->route('teamUniqueId');

        return $data;
    }

    public function getTeamId(): string
    {
        return $this->route('teamUniqueId');
    }
}

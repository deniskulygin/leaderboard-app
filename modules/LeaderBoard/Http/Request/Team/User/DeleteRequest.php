<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Request\Team\User;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    public function getTeamId(): string
    {
        return $this->route('teamUniqueId');
    }

    public function getUserId(): string
    {
        return $this->route('userUniqueId');
    }
}

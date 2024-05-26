<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Request\Team\Counter;

use Illuminate\Foundation\Http\FormRequest;

class GetRequest extends FormRequest
{
    public function getTeamId(): string
    {
        return $this->route('teamUniqueId');
    }

    public function getCounterId(): string
    {
        return $this->route('counterUniqueId');
    }
}

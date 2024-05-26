<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class ListRequest extends FormRequest
{
    public const PER_PAGE = 20;

    public function rules(): array
    {
        return [
            'per_page' => 'numeric|between:1,100',
        ];
    }

    public function messages()
    {
        return [
            'per_page.between' => 'per_page must be a digit from 1 to 100',
        ];
    }

    public function all($keys = null): array
    {

        $data = parent::all();
        $data['per_page'] = (int) $this->query('per_page', self::PER_PAGE);

        return $data;
    }

    public function getPerPage(): int
    {
        return self::all()['per_page'];
    }
}

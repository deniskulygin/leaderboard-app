<?php
declare(strict_types = 1);

namespace LeaderBoard\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class JsonFormRequest extends FormRequest
{
    public function validationData()
    {
        $requestData = [];
        $originalRequestData = $this->getContent();

        if (is_string($originalRequestData)) {
            $requestData = json_decode($originalRequestData, true);
        }

        if (empty($requestData)) {
            throw new \LogicException('Invalid Payload');
        }

        return $requestData;
    }
}

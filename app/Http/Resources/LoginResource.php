<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    private $token;

    public function __construct($resource, $token)
    {
        parent::__construct($resource);
        $this->token = $token;
    }

    public function toArray(Request $request)
    {
        $arrToken = explode('|', $this->token);

        return [
            'token' => end($arrToken),
        ];
    }
}

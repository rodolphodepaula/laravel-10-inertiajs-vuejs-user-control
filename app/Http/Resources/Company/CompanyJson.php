<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\AllResources;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyJson extends JsonResource
{
    use AllResources;

    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'code' => $this->code,
            'status' => $this->status,
        ];
    }
}
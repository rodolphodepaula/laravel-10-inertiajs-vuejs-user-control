<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->transform(function ($model) {
            return new CompanyJson($model);
        });
    }
}

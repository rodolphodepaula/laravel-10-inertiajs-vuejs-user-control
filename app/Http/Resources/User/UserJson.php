<?php

namespace App\Http\Resources\User;

use App\Http\Resources\AllResources;
use App\Http\Resources\Company\CompanyCollection;
use App\Models\Company;
use Illuminate\Http\Resources\Json\JsonResource;

class UserJson extends JsonResource
{
    use AllResources;

    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'company' => $this->company->name,
            'person' => $this->person ?? null,
            'email' => $this->email,
            'is_admin' => $this->isMaster(),
            'enrollment' => $this->enrollment,
            'status_id' => $this->status_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function includeCompanies()
    {
        $companies = Company::all();

        $this->item('companies', new CompanyCollection($companies));
    }
}
<?php

namespace App\Services\Company;

use App\Services\AbstractService;
use Illuminate\Database\Eloquent\Builder;

class CompanyService extends AbstractService
{
    public function getBySearch(Builder $company, array $search = []): Builder
    {
        if (! empty($search['name']) ?? '') {
            $company->whereName($search['name']);
        }

        return $company;
    }

}
<?php

namespace App\Services\Person;

use DB;
use App\Models\Company;
use App\Models\Person;
use App\Services\AbstractService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;


class PersonService extends AbstractService
{
    public function getBySearch(Builder $user, array $search = []): Builder
    {
        return $user;
    }

    public function save(array $params): Person
    {
        return DB::transaction(function () use ($params){
            $person = Person::firstOrCreate(
                ['email' =>$params['email']],
                [
                    'name' => $params['name'],
                    'email' => $params['email'],
                    'company_id' => $params['company_id'],
                    'user_id' => $params['user_id'],
                    'enrollment' =>  $params['enrollment'],
                ]
            );

            return $person;
        });
    }

    public function update(array $params): Person
    {
        return DB::transaction(function () use ($params){
            $person = Person::updateOrCreate(
                ['uuid' =>$params['uuid']],
                [
                    'name' => $params['name'],
                    'email' => $params['email'],
                    'company_id' => $params['company_id'],
                    'user_id' => $params['user_id'],
                    'enrollment' =>  $params['enrollment'],
                ]
            );

            return $person;
        });
    }

}
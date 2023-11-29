<?php

namespace App\Services\User;

use App\Models\Company;
use App\Models\Person;
use DB;
use App\Models\User;
use App\Services\AbstractService;
use App\Services\Person\PersonService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserService extends AbstractService
{
    public function getBySearch(Builder $user, array $search = []): Builder
    {
        if (! empty($search['name']) ?? '') {
            $user->whereNameOrMail($search['name']);
        }

        if (! empty($search['email']) ?? '') {
            $user->where('users.email', 'LIKE', '%'.$search['email'].'%');
        }

        return $user;
    }

    public function save(array $params): User
    {
        return DB::transaction(function () use ($params){
            $email = strtolower(remove_accents(trim($params['email'])));
            $password = Hash::make($params['password']);
            $companyId = Company::whereUuid($params['company_uuid'] ?? '')->value('id');

            $user = new User([
                'name' => $params['name'],
                'email' => $email,
                'password' => $password,
                'company_id' => $companyId,
                'status_id' => $params['status'] ?? false,
            ]);

            $user->save();

            $srvPerson = app(PersonService::class);
            $srvPerson->save([
                'company_id' => $user->company_id,
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'enrollment' => $params['enrollment'] ?? '',
            ]);

            return $user;
        });
    }

    public function update(User $user, array $params): User
    {
        return DB::transaction(function () use ($user, $params) {
            if (! empty($params['password'] ?? '')) {
                $params['password'] = Hash::make($params['password']);
            }

            if (! empty($params['email'] ?? '')) {
                $params['email'] = strtolower(remove_accents(trim($params['email'])));
            }

            $user->fill($params);
            $user->save();

            $srvPerson = app(PersonService::class);
            $srvPerson->save([
                'uuid' => $user->uuid,
                'company_id' => $user->company_id,
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'enrollment' => $params['enrollment'] ?? '',
            ]);

            return $user;
        });
    }

    public function delete(User $user): User
    {
        return DB::transaction(function () use ($user) {
            $user->person->delete();
            $user->delete();

            return $user;
        });
    }
}
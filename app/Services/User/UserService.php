<?php

namespace App\Services\User;

use App\Services\AbstractService;
use Illuminate\Database\Eloquent\Builder;

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

        /* if (! empty($search['squad_uuid']) ?? '') {
            $squads = explode(',', $search['squad_uuid']);
            $user->where(function ($query) use ($squads) {
                $query->whereInSquadUuid($squads);
                if (in_array('-', $squads)) {
                    $query->orWhere(function ($query) {
                        $query->whereIsNotSquad();
                    });
                }
            });
        } else {
            if (isset($search['is_squad']) && $search['is_squad'] === false) {
                $user->whereIsNotSquad();
            }
        } */

        /* if (! empty($search['profile']) ?? '') {
            $user->whereProfile(explode(',', $search['profile']));
        } */

        return $user;
    }

}
<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Traits\AllModels;
use App\Models\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, AllModels, UsesUuid, SoftDeletes;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
        'is_admin',
        'status_id',
        'source',
        'language',
        'timezone',
        'uuid',
        'is_change_password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function scopeIsActive()
    {
        return $this->status_id === self::STATUS_ACTIVE;
    }

    public function scopeWhereName(Builder $query, string $search = ''): Builder
    {
        $searchNames = explode(',', $search);
        foreach ($searchNames as $name) {
            $query->where(function ($query) use ($name) {
                foreach (explode(' ', $name) as $explName) {
                    $query->Where('users.name', 'LIKE', '%'.$explName.'%');
                }
            });
        }

        return $query;
    }

    public function scopeWhereNameOrMail(Builder $query, string $search = ''): Builder
    {
        $searchs = explode(',', $search);
        $query->where(function ($query) use ($searchs) {
            foreach ($searchs as $value) {
                $searchNames = explode(' ', $value);
                if (count($searchNames) > 1) {
                    $query->orWhere(function ($query) use ($searchNames) {
                        foreach ($searchNames as $name) {
                            $query->where('users.name', 'LIKE', '%'.$name.'%');
                        }
                    });
                } else {
                    $query->orWhere('users.name', 'LIKE', '%'.trim($value).'%');
                }
                $query->orWhere('users.email', 'LIKE', '%'.trim($value).'%');
            }
        });

        return $query;
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}

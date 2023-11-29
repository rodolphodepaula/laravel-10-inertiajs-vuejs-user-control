<?php

namespace App\Models;

use App\Models\Traits\AllModels;
use App\Models\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as ContractsAuditable;

class Company extends Model
{
    use SoftDeletes;
    use UsesUuid;
    use AllModels;
    use HasFactory;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    protected $fillable = [
        'uuid',
        'name',
        'code',
        'status',
    ];

    protected $casts = [
        'status' => 'bool',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}

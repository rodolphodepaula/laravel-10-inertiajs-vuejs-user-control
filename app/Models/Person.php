<?php

namespace App\Models;

use App\Models\Traits\AllModels;
use App\Models\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use SoftDeletes;
    use UsesUuid;
    use AllModels;

    protected $table = 'person';

    protected $fillable = [
        'uuid',
        'account_id',
        'email',
        'name',
        'user_id',
        'enrollment',
        'image_id',
        'status_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

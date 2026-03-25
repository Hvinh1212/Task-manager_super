<?php

namespace App\Models;

use App\Traits\HasTaskStatuses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasTaskStatuses;

    public const STATUS_CHUA_LAM = 'chua_lam';
    public const STATUS_DANG_LAM = 'dang_lam';
    public const STATUS_HOAN_THANH = 'hoan_thanh';

    protected $fillable = [
        'title',
        'content',
        'assigned_user_id',
        'status',
    ];

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_DONE = 'done';

    /**
     * Scope a query to filter by status.
     */
    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        if ($status === null || $status === '') {
            return $query;
        }
        return $query->where('status', $status);
    }

    /**
     * Scope a query to perform simple search on title/description.
     */
    public function scopeSearch(Builder $query, ?string $q): Builder
    {
        if ($q === null || $q === '') {
            return $query;
        }
        return $query->where(function (Builder $sub) use ($q) {
            $sub->where('title', 'like', '%' . $q . '%')
                ->orWhere('description', 'like', '%' . $q . '%');
        });
    }
}


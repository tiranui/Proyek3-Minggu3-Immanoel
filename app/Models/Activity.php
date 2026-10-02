<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read bool $trashed    // dihitung via trashed()
 *
 * @method static Builder|Activity onlyTrashed()
 * @method static Builder|Activity withTrashed()
 * @method static Builder|Activity withoutTrashed()
 */
class Activity extends Model
{
    use SoftDeletes;  

    public const STATUSES = ['draft', 'published', 'completed'];

    protected $fillable = [
        'code', 'title', 'description',
        'activity_date', 'category_id', 'status',
    ];

    protected function casts(): array
    {
        return ['activity_date' => 'date'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // ---- Local Scopes ----
    public function scopeSearch(Builder $q, ?string $search): Builder
    {
        return $q->when($search, fn (Builder $q) => $q->where(function (Builder $q) use ($search) {
            $q->where('code', 'like', "%{$search}%")
              ->orWhere('title', 'like', "%{$search}%");
        }));
    }

    public function scopeCategory(Builder $q, ?int $categoryId): Builder
    {
        return $q->when($categoryId, fn (Builder $q) => $q->where('category_id', $categoryId));
    }

    public function scopeStatus(Builder $q, ?string $status): Builder
    {
        return $q->when(
            $status && in_array($status, self::STATUSES, true),
            fn (Builder $q) => $q->where('status', $status)
        );
    }

    public function scopeSortByStartAt(Builder $q, ?string $sort): Builder
    {
        return $sort === 'oldest'
            ? $q->orderBy('activity_date')->orderBy('id')
            : $q->orderByDesc('activity_date')->orderByDesc('id');
    }

    /** Hanya yang terhapus (trashed). */
    public function scopeOnlyTrashedFilter(Builder $q, bool $onlyTrashed): Builder
    {
        return $onlyTrashed ? $q->onlyTrashed() : $q;
    }

    // ---- Helpers ----
    public function isDraft(): bool      { return $this->status === 'draft'; }
    public function isPublished(): bool  { return $this->status === 'published'; }
    public function isCompleted(): bool  { return $this->status === 'completed'; }

    public function isComplete(): bool
    {
        return filled($this->title)
            && filled($this->description)
            && filled($this->activity_date)
            && filled($this->category_id);
    }
}
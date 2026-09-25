<?php

namespace App\Services;

use App\Models\Activity;
use DomainException;
use Illuminate\Database\Eloquent\Builder;

class ActivityService
{
    /**
     * BR-03A: transisi status hanya boleh berjalan maju.
     * Planned -> Ongoing -> Done. Tidak boleh mundur setelah bergerak maju.
     */
    private const TRANSITIONS = [
        'Planned' => ['Planned', 'Ongoing'],
        'Ongoing' => ['Ongoing', 'Done'],
        'Done' => ['Done'],
    ];

    public function create(array $data): Activity
    {
        return Activity::create($data);
    }

    /**
     * @throws DomainException bila transisi status tidak diizinkan (BR-03A)
     */
    public function update(Activity $activity, array $data): Activity
    {
        $nextStatus = $data['status'] ?? $activity->status;

        $this->ensureValidTransition($activity->status, $nextStatus);

        $activity->update($data);

        return $activity->refresh();
    }

    public function delete(Activity $activity): void
    {
        $activity->delete();
    }

    /**
     * Independent Challenge: filter daftar kegiatan berdasarkan status/kategori
     * tanpa mengubah data asli. Nilai tidak valid diabaikan (tidak melempar error).
     */
    public function filtered(?string $status, ?string $category): Builder
    {
        $allowedStatuses = array_keys(self::TRANSITIONS);

        return Activity::query()
            ->when(
                $status && in_array($status, $allowedStatuses, true),
                fn (Builder $query) => $query->where('status', $status)
            )
            ->when(
                $category,
                fn (Builder $query) => $query->where('category', $category)
            );
    }

    private function ensureValidTransition(string $current, string $next): void
    {
        $allowed = self::TRANSITIONS[$current] ?? [];

        if (! in_array($next, $allowed, true)) {
            throw new DomainException(
                "Transisi status {$current} ke {$next} tidak diizinkan."
            );
        }
    }
}

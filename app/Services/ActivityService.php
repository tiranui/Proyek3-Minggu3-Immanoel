<?php

namespace App\Services;

use App\Models\Activity;
use DomainException;

class ActivityService
{
    public function create(array $data): Activity
    {
        return Activity::create($data + ['status' => 'draft']);
    }

    public function update(Activity $activity, array $data): Activity
    {
        unset($data['status']);
        $activity->update($data);

        return $activity->refresh();
    }

    /** Soft delete: isi deleted_at, data tetap ada. */
    public function delete(Activity $activity): void
    {
        $activity->delete();   // SoftDeletes -> UPDATE deleted_at
    }

    /** Restore: kosongkan deleted_at. */
    public function restore(int $id): Activity
    {
        $activity = Activity::onlyTrashed()->findOrFail($id);
        $activity->restore();

        return $activity->refresh();
    }

    public function publish(Activity $activity): Activity
    {
        if (! $activity->isDraft()) {
            throw new DomainException('Hanya kegiatan berstatus draft yang dapat dipublikasikan.');
        }
        if (! $activity->isComplete()) {
            throw new DomainException('Kegiatan belum lengkap. Isi judul, deskripsi, tanggal, dan kategori terlebih dahulu.');
        }
        $activity->update(['status' => 'published']);

        return $activity->refresh();
    }

    public function complete(Activity $activity): Activity
    {
        if (! $activity->isPublished()) {
            throw new DomainException('Hanya kegiatan berstatus published yang dapat diselesaikan.');
        }
        $activity->update(['status' => 'completed']);

        return $activity->refresh();
    }
}
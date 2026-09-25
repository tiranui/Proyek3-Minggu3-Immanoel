<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Services\ActivityService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{

    public function index(Request $request, ActivityService $service): View
    {
        $status = $request->query('status');
        $category = $request->query('category');

        $activities = $service->filtered($status, $category)
            ->orderBy('activity_date')
            ->get();

        return view('activities.index', [
            'activities' => $activities,
            'selectedStatus' => $status,
            'selectedCategory' => $category,
        ]);
    }

    public function create(): View
    {
        return view('activities.create');
    }


    public function store(StoreActivityRequest $request, ActivityService $service): RedirectResponse
    {
        $activity = $service->create($request->validated());

        return to_route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil dibuat.');
    }

    public function show(Activity $activity): View
    {
        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity): View
    {
        return view('activities.edit', compact('activity'));
    }


    public function update(
        UpdateActivityRequest $request,
        Activity $activity,
        ActivityService $service
    ): RedirectResponse {
        try {
            $service->update($activity, $request->validated());
        } catch (DomainException $exception) {
            return back()
                ->withErrors(['status' => $exception->getMessage()])
                ->withInput();
        }

        return to_route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Activity $activity, ActivityService $service): RedirectResponse
    {
        $service->delete($activity);

        return to_route('activities.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }
}

<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\Category;
use App\Services\ActivityService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
public function index(Request $request): View
{
    $filters = [
        'search'   => $request->query('search'),
        'category' => $request->integer('category') ?: null,
        'status'   => $request->query('status'),
        'sort'     => $request->query('sort', 'newest'),
         'trashed'  => $request->boolean('trashed'),
    ];

    $activities = Activity::query()
        ->select(['id', 'code', 'title', 'activity_date', 'category_id', 'status', 'deleted_at'])
        ->with(['category:id,name'])                // eager load, ambil kolom yang perlu saja
        ->search($filters['search'])
        ->category($filters['category'])
        ->status($filters['status'])
        ->onlyTrashedFilter($filters['trashed'])
        ->sortByStartAt($filters['sort'])
        ->paginate(10)
        ->withQueryString();

    return view('activities.index', [
        'activities' => $activities,
        'categories' => Category::orderBy('name')->get(),
        'filters'    => $filters,
    ]);
}

public function restore(int $id, ActivityService $service): RedirectResponse
{
    $service->restore($id);

    return to_route('activities.index', ['trashed' => 1])
        ->with('success', 'Kegiatan berhasil dipulihkan.');
}
    public function create(): View
    {
        return view('activities.create', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(StoreActivityRequest $request, ActivityService $service): RedirectResponse
    {
        $activity = $service->create($request->validated());

        return to_route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil dibuat sebagai draft.');
    }

    public function show(Activity $activity): View
    {
        $activity->load('category');
        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity): View
    {
        return view('activities.edit', [
            'activity'   => $activity,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(
        UpdateActivityRequest $request,
        Activity $activity,
        ActivityService $service
    ): RedirectResponse {
        $service->update($activity, $request->validated());

        return to_route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Activity $activity, ActivityService $service): RedirectResponse
    {
        $service->delete($activity);

        return to_route('activities.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }

    public function publish(Activity $activity, ActivityService $service): RedirectResponse
    {
        try {
            $service->publish($activity);
        } catch (DomainException $e) {
            return back()->withErrors(['status' => $e->getMessage()]);
        }

        return back()->with('success', 'Kegiatan berhasil dipublikasikan.');
    }

    public function complete(Activity $activity, ActivityService $service): RedirectResponse
    {
        try {
            $service->complete($activity);
        } catch (DomainException $e) {
            return back()->withErrors(['status' => $e->getMessage()]);
        }

        return back()->with('success', 'Kegiatan berhasil diselesaikan.');
    }
    public function toDraft(Activity $activity, ActivityService $service): RedirectResponse
{
    try {
        $service->toDraft($activity);
    } catch (DomainException $e) {
        return back()->withErrors(['status' => $e->getMessage()]);
    }

    return back()->with('success', 'Kegiatan dikembalikan ke draft.');
}
}
@extends('layouts.app')

@section('title', 'Daftar Kegiatan')

@section('content')
    <h1>Daftar Kegiatan</h1>

    {{-- Independent Challenge: filter status via query string, GET /activities?status=Planned --}}
    <form method="GET" action="{{ route('activities.index') }}" style="margin-bottom: 1.5rem;">
        <label for="status">Filter Status</label>
        <select name="status" id="status" onchange="this.form.submit()">
            <option value="" @selected(!$selectedStatus)>Semua</option>
            @foreach (['Planned', 'Ongoing', 'Done'] as $status)
                <option value="{{ $status }}" @selected($selectedStatus === $status)>{{ $status }}</option>
            @endforeach
        </select>
    </form>

    @forelse ($activities as $activity)
        <article class="card">
            <h2>
                <a href="{{ route('activities.show', $activity) }}">{{ $activity->title }}</a>
            </h2>
            <p>{{ $activity->activity_date->format('d M Y') }} &middot; {{ $activity->category }}</p>
            <span class="badge badge-{{ $activity->status }}">{{ $activity->status }}</span>
        </article>
    @empty
        <p>Belum ada kegiatan.</p>
    @endforelse
@endsection

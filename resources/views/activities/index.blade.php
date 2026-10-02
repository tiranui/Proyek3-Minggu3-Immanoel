@extends('layouts.app')

@section('title', 'Daftar Kegiatan')

@section('content')
    <h1>Daftar Kegiatan</h1>

    <form method="GET" action="{{ route('activities.index') }}" class="filter-bar">
        <input type="text" name="search" placeholder="Cari code / title"
               value="{{ $filters['search'] }}">

        <select name="category">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" @selected($filters['category'] == $cat->id)>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <select name="status">
            <option value="">Semua Status</option>
            @foreach (['draft', 'published', 'completed'] as $s)
                <option value="{{ $s }}" @selected($filters['status'] === $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>

        <select name="sort">
            <option value="newest" @selected($filters['sort'] === 'newest')>Terbaru</option>
            <option value="oldest" @selected($filters['sort'] === 'oldest')>Terlama</option>
        </select>

        <label>
            <input type="checkbox" name="trashed" value="1" @checked($filters['trashed'])>
            Tampilkan yang terhapus
        </label>

        <button type="submit" class="btn-primary">Filter</button>
        <a class="btn" href="{{ route('activities.index') }}">Reset</a>
    </form>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <p class="muted">
        Menampilkan {{ $activities->firstItem() ?? 0 }}–{{ $activities->lastItem() ?? 0 }}
        dari {{ $activities->total() }} kegiatan.
    </p>

    @forelse ($activities as $activity)
        <article class="card">
            <h2>
                @if ($activity->trashed())
                    <span style="opacity:.5">{{ $activity->title }}</span>
                @else
                    <a href="{{ route('activities.show', $activity) }}">{{ $activity->title }}</a>
                @endif
            </h2>
            <p>
                [{{ $activity->code }}] ·
                {{ $activity->activity_date->format('d M Y') }} ·
                {{ $activity->category?->name ?? '-' }}
            </p>
            <span class="badge badge-{{ $activity->status }}">{{ $activity->status }}</span>

            @if ($activity->trashed())
                <span class="badge">terhapus</span>
                <form method="POST" action="{{ route('activities.restore', $activity->id) }}" style="display:inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn">Restore</button>
                </form>
            @endif
        </article>
    @empty
        <p>Tidak ada kegiatan yang cocok.</p>
    @endforelse

    <div class="pagination">{{ $activities->links() }}</div>
@endsection
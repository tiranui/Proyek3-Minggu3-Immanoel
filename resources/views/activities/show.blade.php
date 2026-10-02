@extends('layouts.app')
@section('title', $activity->title)

@section('content')
    <h1>{{ $activity->title }}</h1>

    @if ($errors->any())
        <div class="alert alert-error">
            @foreach ($errors->all() as $e) <p>{{ $e }}</p> @endforeach
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <p><strong>Kode:</strong> {{ $activity->code }}</p>
    <p><strong>Tanggal:</strong> {{ $activity->activity_date->format('d M Y') }}</p>
    <p><strong>Kategori:</strong> {{ $activity->category->name }}</p>
    <p><strong>Status:</strong> <span class="badge badge-{{ $activity->status }}">{{ $activity->status }}</span></p>
    <p><strong>Deskripsi:</strong> {{ $activity->description ?: '-' }}</p>

    <div class="actions">
        @if ($activity->isDraft())
            <form method="POST" action="{{ route('activities.publish', $activity) }}" style="display:inline">
                @csrf @method('PATCH')
                <button class="btn-primary" type="submit">Publish</button>
            </form>
        @endif

        @if ($activity->isPublished())
            <form method="POST" action="{{ route('activities.complete', $activity) }}" style="display:inline">
                @csrf @method('PATCH')
                <button class="btn-primary" type="submit">Complete</button>
            </form>
        @endif

        <a class="btn" href="{{ route('activities.edit', $activity) }}">Edit</a>
        <a class="btn" href="{{ route('activities.index') }}">Kembali</a>
    </div>
@endsection
{{-- Tombol pembuktian: completed -> draft harus ditolak --}}
@if ($activity->isCompleted())
    <form method="POST" action="{{ route('activities.toDraft', $activity) }}" style="display:inline">
        @csrf
        @method('PATCH')
        <button class="btn" type="submit">Kembalikan ke Draft</button>
    </form>
@endif
@if (! $activity->trashed())
    <form method="POST" action="{{ route('activities.destroy', $activity) }}"
          style="display:inline"
          onsubmit="return confirm('Yakin hapus kegiatan ini?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn">Hapus</button>
    </form>
@endif
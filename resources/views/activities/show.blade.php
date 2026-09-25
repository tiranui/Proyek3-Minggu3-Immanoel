@extends('layouts.app')

@section('title', $activity->title)

@section('content')
    <h1>{{ $activity->title }}</h1>
    <span class="badge badge-{{ $activity->status }}">{{ $activity->status }}</span>

    <p><strong>Tanggal:</strong> {{ $activity->activity_date->format('d M Y') }}</p>
    <p><strong>Kategori:</strong> {{ $activity->category }}</p>
    <p><strong>Deskripsi:</strong> {{ $activity->description ?: '-' }}</p>

    <div class="actions">
        <a class="btn" href="{{ route('activities.edit', $activity) }}">Ubah</a>

        <form method="POST" action="{{ route('activities.destroy', $activity) }}"
              onsubmit="return confirm('Hapus kegiatan ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger">Hapus</button>
        </form>

        <a class="btn" href="{{ route('activities.index') }}">Kembali</a>
    </div>
@endsection

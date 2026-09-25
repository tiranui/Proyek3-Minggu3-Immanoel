@extends('layouts.app')

@section('title', 'Ubah Kegiatan')

@section('content')
    <h1>Ubah Kegiatan</h1>

    <form method="POST" action="{{ route('activities.update', $activity) }}">
        @csrf
        @method('PUT')
        @include('activities._form')

        <div class="actions">
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
            <a class="btn" href="{{ route('activities.show', $activity) }}">Batal</a>
        </div>
    </form>
@endsection

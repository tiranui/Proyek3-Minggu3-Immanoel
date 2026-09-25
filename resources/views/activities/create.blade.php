@extends('layouts.app')

@section('title', 'Tambah Kegiatan')

@section('content')
    <h1>Tambah Kegiatan</h1>

    <form method="POST" action="{{ route('activities.store') }}">
        @csrf
        @include('activities._form')

        <div class="actions">
            <button type="submit" class="btn-primary">Simpan</button>
            <a class="btn" href="{{ route('activities.index') }}">Batal</a>
        </div>
    </form>
@endsection

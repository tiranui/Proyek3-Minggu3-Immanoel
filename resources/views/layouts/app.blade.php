<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Activity Manager')</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 800px; margin: 2rem auto; padding: 0 1rem; color: #1f2937; }
        nav { margin-bottom: 1.5rem; }
        nav a { text-decoration: none; color: #2563eb; font-weight: 600; }
        .card { border: 1px solid #e5e7eb; border-radius: 8px; padding: 1rem; margin-bottom: 1rem; }
        .badge { display: inline-block; padding: 0.15rem 0.6rem; border-radius: 999px; font-size: 0.8rem; }
        .badge-Planned { background: #e0e7ff; color: #3730a3; }
        .badge-Ongoing { background: #fef3c7; color: #92400e; }
        .badge-Done { background: #dcfce7; color: #166534; }
        .error { color: #dc2626; font-size: 0.875rem; margin: 0.15rem 0 0.5rem; }
        .success { background: #dcfce7; color: #166534; padding: 0.75rem; border-radius: 6px; margin-bottom: 1rem; }
        form label { display: block; margin-top: 0.75rem; font-weight: 600; }
        form input, form textarea, form select { width: 100%; padding: 0.5rem; margin-top: 0.25rem; box-sizing: border-box; }
        .actions { margin-top: 1rem; display: flex; gap: 0.5rem; }
        button, .btn { padding: 0.5rem 1rem; border-radius: 6px; border: 1px solid #d1d5db; background: #fff; cursor: pointer; }
        .btn-primary { background: #2563eb; color: #fff; border-color: #2563eb; }
        .btn-danger { background: #dc2626; color: #fff; border-color: #dc2626; }
    </style>
</head>
<body>
    <nav>
        <a href="{{ route('activities.index') }}">Daftar Kegiatan</a>
        &nbsp;|&nbsp;
        <a href="{{ route('activities.create') }}">+ Tambah Kegiatan</a>
    </nav>

    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @yield('content')
</body>
</html>

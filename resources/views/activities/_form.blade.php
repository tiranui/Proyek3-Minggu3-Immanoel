<div>
    <label for="code">Kode</label>
    <input type="text" id="code" name="code"
           value="{{ old('code', $activity->code ?? '') }}" required>
    @error('code') <p class="error">{{ $message }}</p> @enderror
</div>

<div>
    <label for="title">Judul</label>
    <input type="text" id="title" name="title"
           value="{{ old('title', $activity->title ?? '') }}" required>
    @error('title') <p class="error">{{ $message }}</p> @enderror
</div>

<div>
    <label for="description">Deskripsi</label>
    <textarea id="description" name="description" required>{{ old('description', $activity->description ?? '') }}</textarea>
    @error('description') <p class="error">{{ $message }}</p> @enderror
</div>

<div>
    <label for="activity_date">Tanggal</label>
    <input type="date" id="activity_date" name="activity_date"
           value="{{ old('activity_date', isset($activity) ? $activity->activity_date->format('Y-m-d') : '') }}" required>
    @error('activity_date') <p class="error">{{ $message }}</p> @enderror
</div>

<div>
    <label for="category_id">Kategori</label>
    <select id="category_id" name="category_id" required>
        <option value="">-- Pilih Kategori --</option>
        @foreach ($categories as $cat)
            <option value="{{ $cat->id }}"
                @selected(old('category_id', $activity->category_id ?? '') == $cat->id)>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
    @error('category_id') <p class="error">{{ $message }}</p> @enderror
</div>
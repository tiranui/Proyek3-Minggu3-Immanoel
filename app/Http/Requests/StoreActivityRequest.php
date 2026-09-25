<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Modul 3 belum menerapkan authentication/authorization (BR-04/BR-05 ada di Modul 5).
        return true;
    }

    public function rules(): array
    {
        return [
            // BR-01: judul wajib, teks, 5-100 karakter.
            'title' => ['required', 'string', 'min:5', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            // BR-02: tanggal wajib dan valid.
            'activity_date' => ['required', 'date'],
            'category' => ['required', 'string', 'max:50'],
            // BR-03: status hanya boleh salah satu dari tiga nilai berikut.
            'status' => ['required', Rule::in(['Planned', 'Ongoing', 'Done'])],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul kegiatan wajib diisi.',
            'title.min' => 'Judul minimal 5 karakter.',
            'title.max' => 'Judul maksimal 100 karakter.',
            'activity_date.required' => 'Tanggal kegiatan wajib diisi.',
            'activity_date.date' => 'Tanggal kegiatan tidak valid.',
            'category.required' => 'Kategori kegiatan wajib diisi.',
            'status.required' => 'Status kegiatan wajib dipilih.',
            'status.in' => 'Status hanya boleh Planned, Ongoing, atau Done.',
        ];
    }
}

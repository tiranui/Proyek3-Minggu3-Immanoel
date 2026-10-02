<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code'          => ['required', 'string', 'max:20', 'unique:activities,code'],
            'title'         => ['required', 'string', 'min:5', 'max:100'],
            'description'   => ['required', 'string', 'max:1000'],
            'activity_date' => ['required', 'date'],
            'category_id'   => ['required', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required'          => 'Kode kegiatan wajib diisi.',
            'code.unique'            => 'Kode kegiatan sudah digunakan.',
            'title.required'         => 'Judul wajib diisi.',
            'title.min'              => 'Judul minimal 5 karakter.',
            'description.required'   => 'Deskripsi wajib diisi.',
            'activity_date.required' => 'Tanggal wajib diisi.',
            'activity_date.date'     => 'Tanggal tidak valid.',
            'category_id.required'   => 'Kategori wajib dipilih.',
            'category_id.exists'     => 'Kategori tidak valid.',
        ];
    }
}
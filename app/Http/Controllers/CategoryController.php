<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    public function destroy(Category $category): RedirectResponse
    {
        if ($category->activities()->exists()) {
            return back()->withErrors([
                'category' => "Kategori \"{$category->name}\" masih dipakai oleh kegiatan dan tidak dapat dihapus.",
            ]);
        }

        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
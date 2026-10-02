<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            // Hapus kolom category string lama
            $table->dropColumn('category');
        });

        Schema::table('activities', function (Blueprint $table) {
            // Kolom code unik (unique index di level DB)
            $table->string('code', 20)->unique()->after('id');

            // Foreign key ke categories, restrict delete (BR-08)
            $table->foreignId('category_id')
                  ->after('code')
                  ->constrained('categories')
                  ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'code']);
            $table->string('category', 50);
        });
    }
};
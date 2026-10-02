<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Normalisasi data lama -> draft
        DB::table('activities')->update(['status' => 'draft']);

        Schema::table('activities', function (Blueprint $table) {
            $table->string('status', 20)->default('draft')->change();
        });
    }

    public function down(): void {
        Schema::table('activities', function (Blueprint $table) {
            $table->string('status', 20)->default('Planned')->change();
        });
    }
};
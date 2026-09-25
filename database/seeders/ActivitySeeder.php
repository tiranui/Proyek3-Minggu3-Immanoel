<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        Activity::query()->insert([
            [
                'title' => 'Workshop Git Dasar',
                'description' => 'Latihan kolaborasi repository menggunakan branch dan pull request.',
                'activity_date' => '2026-10-05',
                'category' => 'Workshop',
                'status' => 'Planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Seminar Web Quality',
                'description' => 'Pengenalan maintainability, clean code, dan testing dasar.',
                'activity_date' => '2026-10-12',
                'category' => 'Seminar',
                'status' => 'Planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Praktikum Laravel Basic',
                'description' => 'Sesi praktikum membangun Activity Manager v1.',
                'activity_date' => '2026-09-22',
                'category' => 'Praktikum',
                'status' => 'Ongoing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Code Review Modul 2',
                'description' => 'Peninjauan tugas Vanilla JavaScript sebelum lanjut ke Modul 3.',
                'activity_date' => '2026-09-15',
                'category' => 'Review',
                'status' => 'Done',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Persiapan SonarQube',
                'description' => 'Instalasi dan konfigurasi endpoint SonarQube kelas.',
                'activity_date' => '2026-09-10',
                'category' => 'Setup',
                'status' => 'Done',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

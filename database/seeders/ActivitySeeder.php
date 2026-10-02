<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori sudah ada
        if (Category::count() === 0) {
            $this->call(CategorySeeder::class);
        }

        $categoryIds = Category::pluck('id')->toArray();

        $statuses = ['draft', 'published', 'completed'];

        for ($i = 1; $i <= 15; $i++) {
            Activity::create([
                'code'          => 'ACT-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'title'         => 'Kegiatan ' . $i . ' — ' . $this->randomTitle(),
                'description'   => 'Deskripsi kegiatan nomor ' . $i . '. Ini data dummy untuk uji pagination.',
                'activity_date' => now()->subDays(15 - $i)->format('Y-m-d'),
                'category_id'   => $categoryIds[array_rand($categoryIds)],
                'status'        => $statuses[array_rand($statuses)],
            ]);
        }
    }

    private function randomTitle(): string
    {
        $titles = [
            'Belajar Laravel', 'Workshop UI/UX', 'Seminar AI',
            'Lomba Coding', 'Pelatihan Git', 'Diskusi Backend',
            'Review Code', 'Hackathon', 'Meetup Developer',
            'Kelas Database', 'Tutorial API', 'Bedah Framework',
            'Live Coding', 'Sharing Session', 'Study Group',
        ];

        return $titles[array_rand($titles)];
    }
}
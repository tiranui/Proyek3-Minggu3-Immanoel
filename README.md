# Activity Manager v1 — Modul 3 (Laravel Basic)

Nama: Immanoel · NIM: 251511042 · Kelas: 2B

Versi baseline: PHP 8.5.10 · Composer 2.10.3 · Laravel 13.32.0 · SQLite

## Cara menjalankan dari clone baru

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
```

Buka http://127.0.0.1:8000 — otomatis diarahkan ke `/activities`.

## Route utama

| Method | URI | Nama Route | Fungsi |
|---|---|---|---|
| GET | /activities | activities.index | Daftar + filter status |
| GET | /activities/create | activities.create | Form tambah |
| POST | /activities | activities.store | Simpan data baru |
| GET | /activities/{activity} | activities.show | Detail |
| GET | /activities/{activity}/edit | activities.edit | Form ubah |
| PUT/PATCH | /activities/{activity} | activities.update | Simpan perubahan |
| DELETE | /activities/{activity} | activities.destroy | Hapus |

## Menjalankan static analysis

```bash
./vendor/bin/pint
sonar-scanner -Dsonar.host.url=http://ALAMAT-SONARQUBE -Dsonar.token=TOKEN
```

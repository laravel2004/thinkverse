# Planning Implementasi Konten Dinamis Halaman Public ThinkVerse

Dokumen ini dibuat sebagai panduan implementasi untuk junior programmer atau AI model yang lebih murah. Fokus pekerjaan adalah membuat konten halaman public bisa dikelola dari admin tanpa mengubah tampilan dan tanpa mengubah isi awal yang sedang tampil sekarang.

Halaman yang wajib dipelajari dan dibuat dinamis:

- `resources/views/pages/home.blade.php`
- `resources/views/pages/about.blade.php`
- `resources/views/pages/contact.blade.php`
- `resources/views/pages/courses.blade.php`

Catatan: prompt menyebut `course`, tetapi file yang tersedia di project adalah `courses.blade.php`. Gunakan halaman ini sebagai halaman course/katalog kursus.

---

## Tujuan Utama

1. Admin bisa mengubah teks, gambar, tombol, kontak, CTA, dan section marketing pada halaman Home, About, Contact, dan Courses.
2. Isi awal setelah fitur selesai harus sama dengan isi hardcoded yang ada saat ini.
3. Data kursus yang sudah dinamis dari model `Course` tetap dipakai dan tidak diganti dengan konten statis.
4. Perubahan harus mengikuti pola Laravel yang sudah ada: route di `routes/web.php`, controller admin di `app/Http/Controllers/Admin`, model di `app/Models`, migration di `database/migrations`, dan view Blade di `resources/views`.
5. Jika konten belum ada di database, halaman public tetap memiliki fallback agar tidak blank.

---

## Kondisi Saat Ini

### Home

File: `resources/views/pages/home.blade.php`

Konten yang masih hardcoded:

- Badge hero: `Platform Pembelajaran Terstruktur`
- Judul hero: `Belajar lebih mudah dengan ThinkVerse`
- Deskripsi hero.
- Tombol utama: `Mulai Belajar Sekarang`
- Tombol kedua: `Lihat Katalog Course`
- Gambar hero dashboard.
- Floating stat: `10,000+` dan `Siswa Terdaftar`
- Section founder:
  - Role: `Founder & Lead Mentor`
  - Nama: `Mutty Hariyati`
  - Quote founder.
  - Bio founder.
  - Foto founder.
  - Link sosial masih `#`.
- Section feature:
  - Judul: `Kenapa Belajar di ThinkVerse?`
  - Deskripsi section.
  - 4 feature card: Kurikulum Terstruktur, Video Pembelajaran HD, E-Book Eksklusif, Komunitas & Diskusi.
- Section katalog kursus:
  - Judul: `Katalog Kursus Unggulan`
  - Deskripsi section.
  - Link `Lihat Semua Kursus`.
  - Card kursus sudah dinamis dari `$latestCourses`.

Yang sudah dinamis:

- Data kursus unggulan memakai `$latestCourses` dari route `/`.
- Thumbnail, kategori, judul, excerpt, dan detail kursus sudah memakai model `Course`.

### About

File: `resources/views/pages/about.blade.php`

Konten yang masih hardcoded:

- Title page: `Tentang Kami - ThinkVerse Premium`
- Badge: `Misi Kami`
- Judul hero: `Membangun Ekosistem Pendidikan yang Inklusif & Modern`
- Deskripsi hero.
- Section `Visi & Nilai Inti`.
- 2 paragraf visi/nilai.
- Gambar tim ThinkVerse.

### Contact

File: `resources/views/pages/contact.blade.php`

Konten yang masih hardcoded:

- Title page: `Kontak - ThinkVerse Premium`
- Judul hero: `Hubungi Kami`
- Deskripsi hero.
- Contact cards:
  - Lokasi Kantor.
  - Email Dukungan.
  - Telepon.
- Detail alamat:
  - `Gedung Inovasi Lt. 4`
  - `Jl. Pendidikan No. 123, Jakarta Selatan`
  - `12345, Indonesia`
- Email: `halo@thinkverse.com`
- Jam operasional: `Senin - Jumat, 09:00 - 17:00 WIB`
- Telepon: `+62 812-3456-7890`
- Form title: `Kirim Pesan`
- Label dan placeholder form.
- Tombol form: `Kirim Pesan Sekarang`

Catatan penting:

- Form contact saat ini belum memiliki endpoint submit karena button memakai `type="button"`.
- Requirement prompt hanya menyebut konten bisa diganti di admin, bukan membuat fitur inbox/contact submission. Jangan tambahkan fitur submit pesan kecuali diminta di task terpisah.

### Courses

File: `resources/views/pages/courses.blade.php`

Konten yang masih hardcoded:

- Title page: `Daftar Course - ThinkVerse Premium`
- Judul hero: `Eksplorasi Kursus Kami`
- Deskripsi hero.
- Tombol hero:
  - `Mulai Belajar Sekarang`
  - `Pelajari Roadmap`
- Gambar hero.
- Placeholder search: `Cari materi pembelajaran atau instruktur...`
- Filter chips:
  - Semua
  - Matematika
  - IPA Terpadu
  - Bahasa Inggris
  - Coding
  - Desain Grafis
  - Bisnis Digital
- Empty state course.
- Tombol load more: `Lihat Lebih Banyak Kursus`
- Newsletter/CTA:
  - Judul: `Mulai Perjalanan Belajar Anda`
  - Deskripsi CTA.
  - Placeholder email: `Alamat email Anda`
  - Tombol: `Daftar Sekarang`

Yang sudah dinamis:

- Grid kursus memakai `$courses` dari `PublicCourseController@index`.
- Pagination sudah memakai `$courses->links()`.
- Card kursus mengambil thumbnail, level, title, excerpt/description, category, dan route detail dari model `Course`.

---

## Rekomendasi Arsitektur

Gunakan pendekatan `PageContent` berbasis JSON per halaman dan section. Alasannya:

- Konten halaman public terdiri dari banyak section marketing yang bentuknya berbeda-beda.
- Lebih cepat dibuat daripada membuat banyak tabel spesifik.
- Cukup fleksibel untuk teks, list fitur, tombol, link, icon, dan path gambar.
- Bisa tetap aman jika validasi payload dilakukan per halaman/section.

Struktur yang disarankan:

- Tabel `page_contents`
- Model `App\Models\PageContent`
- Controller admin `App\Http\Controllers\Admin\PageContentController`
- Service/helper `App\Services\PageContentService` atau repository sederhana untuk mengambil konten dengan fallback.
- File default content, misalnya `config/public_pages.php`, untuk menjaga isi awal sama seperti sekarang.
- Seeder opsional `PageContentSeeder` untuk memasukkan default content ke database.

Jangan mengubah data kursus yang sudah ada di model `Course`. Halaman `courses.blade.php` hanya perlu membuat hero, filter chip, search placeholder, empty state, load more, dan newsletter menjadi dinamis.

---

## Desain Data

### Migration `page_contents`

Buat migration baru, contoh nama:

`database/migrations/YYYY_MM_DD_HHMMSS_create_page_contents_table.php`

Kolom yang disarankan:

- `id`
- `page_key` string, contoh: `home`, `about`, `contact`, `courses`
- `section_key` string, contoh: `hero`, `founder`, `features`, `contact_info`, `newsletter`
- `content` json
- `is_active` boolean default true
- `updated_by` nullable foreign id ke `users`
- timestamps

Tambahkan unique index:

- unique `page_key + section_key`

Contoh schema:

```php
Schema::create('page_contents', function (Blueprint $table) {
    $table->id();
    $table->string('page_key');
    $table->string('section_key');
    $table->json('content');
    $table->boolean('is_active')->default(true);
    $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
    $table->timestamps();

    $table->unique(['page_key', 'section_key']);
});
```

### Model `PageContent`

Buat file:

`app/Models/PageContent.php`

Isi minimal:

- `$fillable`: `page_key`, `section_key`, `content`, `is_active`, `updated_by`
- cast `content` ke `array`
- cast `is_active` ke `boolean`
- relasi `updatedBy()` ke `User`

### Default Content

Buat file:

`config/public_pages.php`

File ini menyimpan semua isi awal yang sekarang masih hardcoded. Fungsi utamanya:

1. Sumber untuk seeder.
2. Fallback saat data belum ada di database.
3. Referensi agar implementer tidak perlu bolak-balik membaca Blade.

Contoh struktur:

```php
return [
    'home' => [
        'hero' => [
            'badge' => 'Platform Pembelajaran Terstruktur',
            'title' => 'Belajar lebih mudah dengan ThinkVerse',
            'highlight' => 'ThinkVerse',
            'description' => 'Akses materi terstruktur...',
            'primary_button_label' => 'Mulai Belajar Sekarang',
            'primary_button_url' => '#',
            'secondary_button_label' => 'Lihat Katalog Course',
            'secondary_button_route' => 'courses',
            'image_url' => 'https://...',
            'image_alt' => 'Dashboard Pembelajaran ThinkVerse',
            'stat_number' => '10,000+',
            'stat_label' => 'Siswa Terdaftar',
        ],
    ],
];
```

Untuk gambar, versi pertama boleh tetap menyimpan URL lama. Jika ingin admin upload gambar, simpan file ke `storage/app/public/page-content` dan simpan path/URL di JSON.

---

## Mapping Konten yang Harus Dibuat Dinamis

### Home Sections

`home.hero`

- `badge`
- `title_before_highlight`
- `title_highlight`
- `title_after_highlight`
- `description`
- `primary_button_label`
- `primary_button_url`
- `secondary_button_label`
- `secondary_button_route` atau `secondary_button_url`
- `image_url` atau `image_path`
- `image_alt`
- `stat_number`
- `stat_label`

`home.founder`

- `role`
- `name`
- `quote`
- `bio`
- `photo_url` atau `photo_path`
- `photo_alt`
- `social_links`, array berisi label, icon, url

Catatan: project sudah memiliki model dan tabel `SiteProfile`, tetapi belum dipakai. Implementer boleh memakai `SiteProfile` untuk data founder jika ingin lebih semantik. Namun untuk scope cepat dan konsisten dengan halaman lain, `PageContent` JSON sudah cukup.

`home.features`

- `title`
- `description`
- `items`, array:
  - `icon`
  - `title`
  - `description`
  - `color_variant`

`home.course_preview`

- `title`
- `description`
- `link_label`
- `link_route` atau `link_url`
- `empty_state_text`

Data card kursus tetap dari `$latestCourses`.

### About Sections

`about.hero`

- `page_title`
- `badge`
- `title_before_highlight`
- `title_highlight`
- `description`

`about.vision`

- `title`
- `paragraphs`, array string
- `image_url` atau `image_path`
- `image_alt`

### Contact Sections

`contact.hero`

- `page_title`
- `title_before_highlight`
- `title_highlight`
- `description`

`contact.info`

- `cards`, array:
  - `icon`
  - `title`
  - `lines`
  - `link_label`
  - `link_url`

Isi awal harus memuat lokasi, email, dan telepon seperti halaman sekarang.

`contact.form`

- `title`
- `fields`, array:
  - `name`
  - `label`
  - `placeholder`
  - `type`
- `button_label`

Catatan: simpan hanya konfigurasi tampilan form. Jangan implementasikan submit pesan kecuali ada requirement baru.

### Courses Sections

`courses.hero`

- `page_title`
- `title`
- `description`
- `primary_button_label`
- `primary_button_url`
- `secondary_button_label`
- `secondary_button_url`
- `image_url` atau `image_path`
- `image_alt`

`courses.filters`

- `search_placeholder`
- `chips`, array string

Catatan: filter chips saat ini hanya tampilan. Jika ingin dibuat benar-benar memfilter data, jadikan task terpisah atau bagian tambahan setelah konten dinamis selesai.

`courses.grid`

- `empty_state_title`
- `load_more_label`
- `detail_label`
- `default_level_label`
- `default_category_label`

Data kursus tetap dari `$courses`.

`courses.newsletter`

- `title`
- `description`
- `email_placeholder`
- `button_label`

Catatan: newsletter saat ini belum memiliki endpoint submit. Jangan tambahkan backend subscription kecuali diminta di task terpisah.

---

## Tahap Implementasi

### Tahap 1: Inventory Konten dan Screenshot Baseline

Estimasi: 0.5 hari.

Yang harus dilakukan:

1. Baca ulang 4 file Blade:
   - `resources/views/pages/home.blade.php`
   - `resources/views/pages/about.blade.php`
   - `resources/views/pages/contact.blade.php`
   - `resources/views/pages/courses.blade.php`
2. Catat semua teks, gambar, alt text, tombol, icon, dan link yang masih hardcoded.
3. Jalankan aplikasi lokal dan ambil screenshot baseline untuk 4 halaman.
4. Pastikan halaman course yang dimaksud adalah route `/courses`, bukan file `course.blade.php`.
5. Catat bagian yang sudah dinamis:
   - `$latestCourses` di Home.
   - `$courses` di Courses.

Output tahap ini:

- Checklist konten final.
- Screenshot baseline sebelum perubahan.
- Konfirmasi bahwa isi awal di config/seeder harus sama dengan hardcoded saat ini.

### Tahap 2: Buat Migration, Model, dan Default Config

Estimasi: 0.5 sampai 1 hari.

Yang harus dilakukan:

1. Buat migration `page_contents`.
2. Buat model `PageContent`.
3. Buat config `config/public_pages.php`.
4. Masukkan semua konten hardcoded sekarang ke config tersebut.
5. Jangan mengubah struktur tabel `courses` karena data kursus sudah berjalan.
6. Jalankan migration.
7. Pastikan cast JSON berjalan benar.

Output tahap ini:

- Tabel `page_contents` tersedia.
- Model `PageContent` siap dipakai.
- Default content lengkap untuk Home, About, Contact, dan Courses.

### Tahap 3: Buat Seeder Default Content

Estimasi: 0.5 hari.

Yang harus dilakukan:

1. Buat `database/seeders/PageContentSeeder.php`.
2. Seeder membaca `config('public_pages')`.
3. Untuk setiap `page_key` dan `section_key`, lakukan `updateOrCreate`.
4. Jangan membuat duplicate jika seeder dijalankan berkali-kali.
5. Daftarkan seeder di `DatabaseSeeder` jika diperlukan.
6. Jalankan seeder di local.

Output tahap ini:

- Database berisi konten awal yang sama dengan tampilan sekarang.
- Seeder idempotent.

### Tahap 4: Buat Service untuk Mengambil Konten

Estimasi: 0.5 hari.

Yang harus dilakukan:

1. Buat service misalnya `app/Services/PageContentService.php`.
2. Buat method:
   - `getPage(string $pageKey): array`
   - `getSection(string $pageKey, string $sectionKey): array`
3. Method harus mengambil data aktif dari database.
4. Jika data tidak ada atau tidak aktif, pakai fallback dari `config/public_pages.php`.
5. Gabungkan data database dengan default agar field baru tidak membuat halaman error.
6. Pertimbangkan cache sederhana dengan `Cache::remember`, tetapi jangan wajib untuk versi pertama.

Output tahap ini:

- Public controller/route bisa mengambil konten tanpa query manual berulang.
- Halaman tidak blank walaupun database kosong.

### Tahap 5: Ubah Route Public Menjadi Mengirim Konten Dinamis

Estimasi: 0.5 hari.

Yang harus dilakukan:

1. Route `/` tetap mengambil `$latestCourses`.
2. Tambahkan `$pageContent = app(PageContentService::class)->getPage('home')`.
3. Kirim `$pageContent` ke `pages.home`.
4. Route `/about` kirim content `about`.
5. Route `/contact` kirim content `contact`.
6. `PublicCourseController@index` kirim content `courses` bersama `$courses`.
7. Jangan menghapus query course yang sudah ada.

Output tahap ini:

- Semua halaman menerima variable konten dinamis.
- Data kursus tetap tampil seperti sebelumnya.

### Tahap 6: Refactor Blade Public

Estimasi: 1 sampai 1.5 hari.

Yang harus dilakukan:

1. Ganti teks hardcoded di Home dengan variable dari `$pageContent`.
2. Ganti teks hardcoded di About dengan variable dari `$pageContent`.
3. Ganti teks hardcoded di Contact dengan variable dari `$pageContent`.
4. Ganti teks hardcoded di Courses dengan variable dari `$pageContent`.
5. Gunakan fallback defensif seperti:
   - `$hero['title'] ?? '...'`
   - `data_get($pageContent, 'hero.title')`
6. Untuk list seperti feature cards, contact cards, dan filter chips, gunakan loop.
7. Pastikan route Blade seperti `route('courses')` tetap aman jika field route disimpan di config.
8. Jangan render HTML bebas dari admin kecuali sudah disanitasi. Untuk versi pertama, gunakan plain text dan textarea.
9. Pastikan gambar bisa memakai URL lama atau path storage.

Output tahap ini:

- 4 halaman public tampil dari data dinamis.
- Tampilan visual tetap sama dengan baseline.
- Course grid dan latest course tetap dinamis dari model `Course`.

### Tahap 7: Buat Admin Page Content Management

Estimasi: 1.5 sampai 2 hari.

Yang harus dilakukan:

1. Tambahkan route admin:
   - `GET /admin/pages`
   - `GET /admin/pages/{pageKey}/edit`
   - `PUT /admin/pages/{pageKey}`
2. Buat controller:
   - `App\Http\Controllers\Admin\PageContentController`
3. Tambahkan menu di sidebar admin, misalnya `Konten Halaman`.
4. Halaman index menampilkan daftar:
   - Home
   - About
   - Contact
   - Courses
5. Halaman edit menampilkan form sesuai halaman.
6. Untuk versi pertama, form boleh dibuat eksplisit per halaman agar mudah dipahami junior:
   - `resources/views/admin/pages/edit-home.blade.php`
   - `resources/views/admin/pages/edit-about.blade.php`
   - `resources/views/admin/pages/edit-contact.blade.php`
   - `resources/views/admin/pages/edit-courses.blade.php`
7. Alternatif: satu view edit generic dengan partial per section.
8. Saat simpan, validasi input lalu update JSON section terkait.
9. Simpan `updated_by` memakai `auth()->id()`.
10. Tampilkan flash message sukses/gagal.

Output tahap ini:

- Admin bisa membuka menu konten halaman.
- Admin bisa mengubah konten Home, About, Contact, dan Courses.
- Data tersimpan ke `page_contents`.

### Tahap 8: Upload Gambar untuk Konten Halaman

Estimasi: 0.5 sampai 1 hari.

Yang harus dilakukan:

1. Tambahkan input file untuk gambar:
   - Home hero image.
   - Home founder photo.
   - About image.
   - Courses hero image.
2. Validasi file:
   - `image`
   - `mimes:jpeg,png,jpg,webp`
   - max 2 MB atau sesuai standar project.
3. Simpan ke disk public:
   - `page-content/home`
   - `page-content/about`
   - `page-content/courses`
4. Jika file baru diupload, update path di JSON.
5. Jangan hapus gambar lama sebelum upload baru berhasil.
6. Pastikan `php artisan storage:link` sudah dijalankan.

Output tahap ini:

- Admin bisa mengganti gambar halaman.
- Halaman public menampilkan gambar baru.
- Jika tidak ada upload, URL/path lama tetap dipakai.

### Tahap 9: Validasi dan Sanitasi

Estimasi: 0.5 hari.

Yang harus dilakukan:

1. Buat validasi per halaman agar struktur JSON tidak rusak.
2. Batasi panjang field:
   - title maksimal 255 karakter.
   - label tombol maksimal 100 karakter.
   - paragraph/description bisa `nullable|string`.
3. Validasi URL untuk link eksternal.
4. Untuk social link, validasi label dan URL.
5. Untuk Material Symbols icon, simpan sebagai string sederhana dan jangan render HTML mentah.
6. Jangan izinkan admin memasukkan script atau iframe di field teks.
7. Gunakan escaping Blade default `{{ }}` untuk teks.

Output tahap ini:

- Input admin tidak mudah merusak halaman.
- Risiko XSS rendah karena tidak render HTML mentah.

### Tahap 10: Testing Manual dan Automated Test

Estimasi: 1 hari.

Automated test minimal:

1. Guest bisa membuka Home.
2. Guest bisa membuka About.
3. Guest bisa membuka Contact.
4. Guest bisa membuka Courses.
5. Home tetap menampilkan latest published courses.
6. Courses tetap menampilkan published courses.
7. Admin bisa membuka halaman edit content.
8. User non-admin tidak bisa membuka halaman edit content.
9. Admin bisa update content Home hero.
10. Setelah update, halaman Home menampilkan teks baru.
11. Jika content database kosong, halaman memakai fallback config.

Manual test:

1. Ambil screenshot sebelum perubahan.
2. Jalankan migration dan seeder.
3. Buka Home, About, Contact, Courses.
4. Bandingkan dengan screenshot baseline.
5. Login sebagai admin.
6. Ubah teks hero Home.
7. Upload gambar baru untuk About.
8. Ubah email dan telepon Contact.
9. Ubah chips Courses.
10. Buka halaman public dan pastikan perubahan tampil.
11. Kembalikan isi ke default jika diperlukan.

Output tahap ini:

- Test utama tersedia.
- Checklist manual selesai.
- Tidak ada regresi pada course grid.

### Tahap 11: Dokumentasi untuk Admin dan Developer

Estimasi: 0.5 hari.

Yang harus dilakukan:

1. Tambahkan catatan di README atau dokumen internal:
   - cara menjalankan seeder.
   - cara mengakses menu admin konten halaman.
   - cara upload gambar.
   - lokasi config fallback.
2. Jelaskan bahwa form contact dan newsletter masih tampilan saja.
3. Jelaskan bahwa filter chips courses masih tampilan saja kecuali dibuat task lanjutan.
4. Dokumentasikan struktur `page_contents.content` agar developer berikutnya tidak menebak-nebak.

Output tahap ini:

- Developer berikutnya bisa melanjutkan tanpa membaca semua Blade.
- Admin tahu bagian mana yang bisa diedit.

---

## Acceptance Criteria

Fitur dianggap selesai jika:

1. Halaman Home, About, Contact, dan Courses mengambil konten dari database atau fallback config.
2. Isi awal sama dengan tampilan hardcoded saat ini.
3. Admin bisa mengedit konten setiap halaman dari dashboard admin.
4. Admin bisa mengganti gambar utama yang relevan.
5. Course grid di `/courses` tetap memakai data `$courses`.
6. Course preview di Home tetap memakai data `$latestCourses`.
7. Jika data `page_contents` belum ada, halaman tetap tampil normal dari fallback.
8. Route admin konten halaman hanya bisa diakses admin.
9. Input admin divalidasi.
10. Tidak ada HTML/script mentah dari admin yang dirender tanpa sanitasi.
11. Tampilan mobile dan desktop tidak berubah signifikan dari baseline.
12. Tidak ada error saat menjalankan test utama.

---

## Task Breakdown yang Disarankan untuk Junior atau AI Model Murah

Kerjakan berurutan dalam task kecil:

1. Tambah migration dan model `PageContent`.
2. Tambah `config/public_pages.php` berisi isi default persis seperti sekarang.
3. Tambah seeder `PageContentSeeder`.
4. Tambah `PageContentService`.
5. Ubah route Home, About, Contact, dan controller Courses agar mengirim `$pageContent`.
6. Refactor `home.blade.php`.
7. Refactor `about.blade.php`.
8. Refactor `contact.blade.php`.
9. Refactor `courses.blade.php`.
10. Tambah route dan controller admin page content.
11. Tambah view admin edit Home.
12. Tambah view admin edit About.
13. Tambah view admin edit Contact.
14. Tambah view admin edit Courses.
15. Tambah upload gambar.
16. Tambah validasi dan test.
17. Bandingkan ulang tampilan dengan baseline.

Jangan meminta AI model murah mengerjakan semua sekaligus. Minta satu task, review diff, jalankan test, lalu lanjut ke task berikutnya.

---

## Catatan Penting untuk Implementer

- Jangan menghapus dynamic course yang sudah ada.
- Jangan membuat form contact benar-benar submit pesan kecuali ada requirement baru.
- Jangan membuat newsletter benar-benar menyimpan subscriber kecuali ada requirement baru.
- Jangan membuat filter chips benar-benar memfilter kursus kecuali masuk scope tambahan.
- Jangan hardcode ulang isi lama di Blade setelah fitur dinamis dibuat; isi lama harus berada di config/seeder/database.
- Gunakan `Storage::url($path)` untuk file upload dari disk public.
- Gunakan `data_get()` agar akses konten nested lebih aman.
- Gunakan escaping Blade default untuk teks dari admin.
- Jaga class Tailwind dan struktur markup semirip mungkin agar visual tidak berubah.

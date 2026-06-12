# Implementation Plan: Benahi CRUD Page Content Admin

Dokumen ini adalah rencana implementasi sebelum memperbaiki CRUD untuk `tests/Feature/Admin/PageContentTest.php`.

Target utamanya: fitur admin page content harus bisa dipakai dan memenuhi kontrak test yang sudah ada, tanpa merusak halaman public Home, About, Contact, dan Courses.

---

## Kontrak dari Test

File test: `tests/Feature/Admin/PageContentTest.php`

Test mengharapkan perilaku berikut:

1. Guest tidak bisa akses route admin page management:
   - `admin.pages.index`
   - `admin.pages.edit`
   - `admin.pages.update`
   - harus redirect ke `/login`.
2. User non-admin tidak bisa akses route admin page management:
   - harus redirect ke `/`.
   - minimal untuk index harus memiliki session `error`.
3. Admin bisa membuka halaman index:
   - status `200`.
   - melihat teks `Kelola Konten Halaman`.
   - melihat key `home`, `about`, `contact`, dan `courses`.
4. Admin bisa membuka form edit Home:
   - status `200`.
   - melihat teks default `Platform Pembelajaran Terstruktur`.
5. Admin bisa update konten Home:
   - request `PUT admin.pages.update` menerima payload `sections`.
   - redirect ke `admin.pages.index`.
   - session memiliki `success`.
   - record `page_contents` untuk `home.hero` tersimpan.
   - halaman public Home menampilkan nilai baru, contoh `NewThinkVerse`.
6. Jika tabel `page_contents` kosong:
   - Home tetap status `200` dan menampilkan `ThinkVerse`.
   - About tetap status `200` dan menampilkan `Tentang Kami`.
   - Contact tetap status `200` dan menampilkan `Hubungi`.
   - Courses tetap status `200` dan menampilkan `Eksplorasi`.

---

## Kondisi Implementasi Saat Ini

Komponen yang sudah ada:

- Route public sudah mengirim `$pageContent` untuk Home, About, Contact.
- `PublicCourseController@index` sudah mengirim `$pageContent` untuk Courses.
- Route admin sudah ada:
  - `GET /admin/pages`
  - `GET /admin/pages/{pageKey}/edit`
  - `PUT /admin/pages/{pageKey}`
- `PageContentController` sudah ada.
- `PageContent` model sudah ada.
- `PageContentService` sudah ada.
- Migration `page_contents` sudah ada.
- `PageContentSeeder` sudah ada.
- Config fallback `config/public_pages.php` sudah ada.
- View admin pages sudah ada.
- Sidebar admin sudah memiliki menu konten halaman.

Potensi masalah yang perlu dibereskan:

1. Test runner belum berhasil dijalankan dari sandbox, jadi perbaikan harus diikuti verifikasi ulang setelah dokumen ini.
2. View index admin mungkin tidak menampilkan literal key `home`, `about`, `contact`, dan `courses`; test memakai `assertSee('home')`, jadi key harus muncul di HTML.
3. Validasi update Home terlalu ketat untuk payload dari test jika ada field default yang tidak ikut atau field nested berubah bentuk.
4. `PageContentService` memakai `array_merge` dangkal; nested array seperti `hero.title_highlight` bisa aman jika satu section penuh dikirim, tetapi lebih aman memakai merge rekursif agar fallback tidak hilang.
5. Update controller menyimpan section yang dikirim saja; ini benar untuk test, tapi harus tetap menjaga section lama saat request parsial.
6. Path gambar upload disimpan di field `image_url`/`photo_url`; Blade public harus bisa membedakan URL eksternal dan path storage.
7. Fallback public harus tidak bergantung pada data hasil seeder.

---

## Scope Perbaikan

Scope yang harus dikerjakan:

1. Pastikan CRUD PageContent berjalan untuk index, edit, dan update.
2. Pastikan route dan middleware sesuai ekspektasi test.
3. Pastikan admin index menampilkan key halaman.
4. Pastikan form edit Home minimal bisa menampilkan default content.
5. Pastikan update `sections` menyimpan JSON per section ke `page_contents`.
6. Pastikan public pages membaca data database dan fallback config.
7. Pastikan fallback tetap jalan saat `page_contents` kosong.
8. Tambahkan atau rapikan validasi agar request test valid.
9. Tambahkan upload foto/gambar untuk konten halaman yang memiliki visual utama.

Di luar scope:

- Membuat contact form benar-benar mengirim pesan.
- Membuat newsletter menyimpan subscriber.
- Membuat filter chips Courses benar-benar memfilter kursus.
- Mengubah CRUD kursus, lesson, assignment, comment, atau submission.
- Merombak desain visual admin atau public.

---

## Rencana Perubahan Teknis

### 1. Verifikasi Route dan Middleware

File:

- `routes/web.php`
- `app/Http/Middleware/AdminMiddleware.php`

Yang harus dipastikan:

- Route admin pages berada di group `middleware(['auth', 'admin'])`.
- Guest akan tertahan middleware `auth` dan redirect ke `/login`.
- User non-admin akan lolos `auth`, lalu ditolak `admin`, redirect ke `/` dengan session `error`.
- Route name harus sama dengan test:
  - `admin.pages.index`
  - `admin.pages.edit`
  - `admin.pages.update`

Kriteria selesai:

- `route('admin.pages.index')`, `route('admin.pages.edit', 'home')`, dan `route('admin.pages.update', 'home')` resolve tanpa error.

### 2. Rapikan Index Page Management

File:

- `resources/views/admin/pages/index.blade.php`

Yang harus dilakukan:

- Tetap tampilkan judul `Kelola Konten Halaman`.
- Pastikan literal key halaman tampil di HTML:
  - `home`
  - `about`
  - `contact`
  - `courses`
- Cara sederhana: tambahkan badge kecil `{{ $key }}` di setiap card.
- Jangan menghapus title deskriptif yang sudah ada.

Kriteria selesai:

- Test `test_admin_can_access_page_management_index` bisa menemukan semua string yang diharapkan.

### 3. Pastikan Edit Home Menampilkan Data Default

File:

- `app/Http/Controllers/Admin/PageContentController.php`
- `resources/views/admin/pages/edit-home.blade.php`
- `app/Services/PageContentService.php`

Yang harus dilakukan:

- `edit('home')` harus mengambil content dari `PageContentService::getPage('home')`.
- Jika database kosong, service harus mengembalikan config fallback.
- View edit Home harus menampilkan `sections.hero.badge`, sehingga `Platform Pembelajaran Terstruktur` terlihat.

Kriteria selesai:

- Admin membuka `admin.pages.edit` untuk `home` dan melihat teks default.

### 4. Buat Update Payload Lebih Tahan Parsial

File:

- `app/Http/Controllers/Admin/PageContentController.php`
- `app/Services/PageContentService.php`

Yang harus dilakukan:

- Request update menerima payload `sections`.
- Validasi `sections` sebagai array.
- Ambil current content dari service.
- Untuk setiap section yang dikirim:
  - merge data lama dan data baru secara rekursif.
  - simpan dengan `PageContent::updateOrCreate`.
  - isi `updated_by` dengan `auth()->id()`.
  - `is_active` true.
- Jangan wajibkan semua section selalu hadir jika request hanya mengupdate satu section.

Catatan:

- Test saat ini mengirim seluruh `config('public_pages.home')`, jadi validasi lengkap bisa lolos.
- Namun agar CRUD benar-benar bisa dipakai, update parsial dari form atau UI masa depan tetap harus aman.

Kriteria selesai:

- `sections.hero.title_highlight = NewThinkVerse` tersimpan.
- Public Home membaca nilai database terbaru.

### 5. Perbaiki Merge Fallback Rekursif

File:

- `app/Services/PageContentService.php`

Yang harus dilakukan:

- Ganti `array_merge` dangkal dengan helper merge rekursif untuk associative array.
- Tujuannya agar update sebagian nested data tidak menghapus default field lain.
- Untuk array list numerik seperti `features.items` atau `filters.chips`, gunakan nilai database sebagai pengganti list default, bukan merge item per index yang membingungkan.

Kriteria selesai:

- Section dengan field parsial tetap punya field default lain.
- List seperti chips tetap sesuai isi database.

### 6. Pastikan Public Blade Menggunakan Fallback Aman

File:

- `resources/views/pages/home.blade.php`
- `resources/views/pages/about.blade.php`
- `resources/views/pages/contact.blade.php`
- `resources/views/pages/courses.blade.php`

Yang harus dilakukan:

- Gunakan `data_get($pageContent, 'section.field')` atau variable section yang sudah diberi fallback.
- Jangan langsung mengakses index array yang bisa undefined.
- Pastikan string yang dicari test tetap muncul saat database kosong:
  - Home: `ThinkVerse`
  - About: `Tentang Kami`
  - Contact: `Hubungi`
  - Courses: `Eksplorasi`

Kriteria selesai:

- `PageContent::truncate()` tidak membuat halaman public error.

### 7. Normalisasi Validasi Update

File:

- `app/Http/Controllers/Admin/PageContentController.php`

Yang harus dilakukan:

- Validasi umum:
  - `sections` required array.
- Validasi per halaman tetap ada, tetapi jangan terlalu ketat untuk field opsional.
- Field URL tombol boleh string biasa karena default memakai `#` dan `/courses`.
- Untuk Contact, pre-process `lines_text` sebelum validasi.
- Untuk Courses, pre-process `chips_text` sebelum validasi.
- Untuk upload image, validasi file hanya jika file dikirim.

Kriteria selesai:

- Payload dari test valid.
- Payload dari form admin valid.
- Upload image yang salah format ditolak.

### 8. Tambahkan Upload Foto Konten Halaman

File:

- `app/Http/Controllers/Admin/PageContentController.php`
- `resources/views/admin/pages/edit-home.blade.php`
- `resources/views/admin/pages/edit-about.blade.php`
- `resources/views/admin/pages/edit-courses.blade.php`
- `resources/views/pages/home.blade.php`
- `resources/views/pages/about.blade.php`
- `resources/views/pages/courses.blade.php`

Field upload yang harus didukung:

- Home hero image: input file `hero_image`, simpan ke `sections.hero.image_url`.
- Home founder photo: input file `founder_photo`, simpan ke `sections.founder.photo_url`.
- About vision/team image: input file `vision_image`, simpan ke `sections.vision.image_url`.
- Courses hero image: input file `courses_hero_image`, simpan ke `sections.hero.image_url`.

Yang harus dilakukan:

1. Pastikan form admin yang memiliki upload memakai:
   - `method="POST"`
   - `@method('PUT')`
   - `enctype="multipart/form-data"`
2. Tambahkan input file di form edit halaman yang relevan.
3. Tampilkan preview gambar saat ini:
   - jika value adalah URL eksternal, pakai langsung.
   - jika value adalah path storage, render dengan `Storage::url($path)`.
4. Di controller update, validasi file hanya jika dikirim:
   - `image`
   - `mimes:jpeg,png,jpg,webp`
   - `max:2048`
5. Simpan file ke disk public:
   - `page-content/home`
   - `page-content/about`
   - `page-content/courses`
6. Setelah upload berhasil, masukkan path hasil `store()` ke payload section:
   - contoh: `$sections['hero']['image_url'] = $path`.
7. Jangan hapus gambar lama sebelum upload baru berhasil.
8. Jika tidak ada file baru, pertahankan value lama dari database/fallback melalui merge payload.
9. Jangan membuat field baru terpisah seperti `image_path` jika Blade dan config memakai `image_url`; gunakan satu field yang sama agar CRUD sederhana.
10. Tambahkan helper kecil jika perlu, misalnya `page_content_asset($value)`, atau lakukan normalisasi di Blade:
    - URL eksternal: `http://`, `https://`, atau `//`.
    - Path storage: `Storage::url($value)`.

Contoh helper render gambar di Blade:

```php
@php
    $image = data_get($pageContent, 'hero.image_url');
    $imageSrc = Str::startsWith($image, ['http://', 'https://', '//'])
        ? $image
        : Storage::url($image);
@endphp
```

Catatan:

- Pastikan `Illuminate\Support\Str` dan `Illuminate\Support\Facades\Storage` tersedia di Blade jika memakai contoh di atas.
- Alternatif lebih rapi: buat helper global atau method service agar logika asset tidak diulang di banyak Blade.
- Jalankan `php artisan storage:link` di environment lokal/production jika gambar dari disk public belum bisa diakses browser.

Kriteria selesai:

- Admin bisa upload foto Home hero.
- Admin bisa upload foto founder Home.
- Admin bisa upload foto About.
- Admin bisa upload foto Courses hero.
- Setelah upload, public page menampilkan gambar baru.
- Jika admin hanya mengubah teks tanpa upload file, gambar lama tidak hilang.
- Upload file non-image ditolak validasi.

### 9. Verifikasi Seeder dan Migration

File:

- `database/migrations/2026_06_12_164201_create_page_contents_table.php`
- `database/seeders/PageContentSeeder.php`
- `database/seeders/DatabaseSeeder.php`
- `app/Models/PageContent.php`

Yang harus dipastikan:

- `content` cast ke array.
- `is_active` cast ke boolean.
- Seeder memakai `updateOrCreate`.
- Seeder tidak wajib untuk public fallback, hanya untuk data awal database.
- Unique index `page_key + section_key` ada.

Kriteria selesai:

- `RefreshDatabase` + seed `PageContentSeeder` bisa mengisi data tanpa duplicate.

---

## Urutan Implementasi

1. Jalankan test target untuk mendapatkan error aktual.
2. Perbaiki index view agar key `home`, `about`, `contact`, `courses` terlihat.
3. Perbaiki `PageContentService` supaya merge fallback rekursif dan aman untuk database kosong.
4. Rapikan `PageContentController@update` agar validasi dan update payload `sections` stabil.
5. Tambahkan upload foto untuk Home, About, dan Courses sesuai field yang sudah ditentukan.
6. Pastikan public Blade bisa render URL eksternal dan path storage.
7. Cek public Blade untuk fallback yang berpotensi undefined.
8. Jalankan `php artisan test tests/Feature/Admin/PageContentTest.php`.
9. Jika gagal, benahi assertion satu per satu tanpa mengubah kontrak test kecuali test memang salah.
10. Jalankan subset test terkait public/auth jika perubahan menyentuh middleware atau route.

---

## Command Verifikasi

Command utama:

```powershell
php artisan test tests\Feature\Admin\PageContentTest.php
```

Jika perlu cek semua feature test:

```powershell
php artisan test tests\Feature
```

Jika perubahan Blade/route terasa luas, jalankan juga:

```powershell
php artisan route:list --name=admin.pages
```

---

## Acceptance Criteria

Perbaikan dianggap selesai jika:

1. `tests/Feature/Admin/PageContentTest.php` pass.
2. Admin bisa membuka `/admin/pages`.
3. Admin bisa membuka edit Home, About, Contact, dan Courses.
4. Admin bisa menyimpan perubahan content dan melihat flash success.
5. Public page menampilkan perubahan dari database.
6. Saat `page_contents` kosong, public page tetap tampil dari `config/public_pages.php`.
7. Guest redirect ke `/login`.
8. User non-admin redirect ke `/` dengan session `error`.
9. Admin bisa upload dan mengganti foto konten halaman yang didukung.
10. Public page bisa menampilkan gambar dari URL eksternal maupun path storage.
11. Tidak ada perubahan pada CRUD kursus yang tidak terkait.

---

## Catatan untuk Implementer

- Jangan mengubah nama route yang sudah dipakai test.
- Jangan menghapus fallback config karena test secara eksplisit mengosongkan `page_contents`.
- Jangan membuat update hanya bekerja untuk Home; route edit/update harus tetap mengenali `about`, `contact`, dan `courses`.
- Jangan menyimpan seluruh halaman sebagai satu record. Simpan per `page_key + section_key` agar sesuai desain dan test database.
- Jangan render input admin sebagai HTML mentah.
- Jangan menyimpan upload foto ke field baru jika field config/Blade sudah memakai `image_url` atau `photo_url`.
- Jangan menghapus referensi gambar lama saat request update tidak membawa file baru.
- Jika command test gagal karena sandbox sebelum PHPUnit berjalan, ulangi command yang sama sebelum menyimpulkan ada error aplikasi.

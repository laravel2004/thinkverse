# Issue: Hilangkan Login/Register User dan Jadikan Komentar serta Pengumpulan Tugas Tanpa Login

Dokumen ini adalah rencana implementasi untuk junior programmer atau AI model yang lebih murah. Fokus pekerjaan adalah menghapus kebutuhan login/register untuk user biasa, mempertahankan login khusus admin pada URL tersembunyi, dan mengubah fitur komentar serta pengumpulan tugas agar bisa dipakai langsung dengan input nama.

## Ringkasan Kebutuhan

1. User biasa tidak perlu login dan tidak perlu register.
2. Fitur login dan register untuk user harus dihapus dari tampilan dan route publik.
3. Admin tetap bisa login, tetapi URL login admin harus dipindah ke:

```text
/sudut-panel/admin/login
```

4. Fitur komentar tidak perlu login. Pengunjung cukup mengisi nama dan isi komentar.
5. Fitur pengumpulan tugas tidak perlu login. Pengunjung cukup mengisi nama dan file tugas.

## Kondisi Saat Ini

File yang sudah teridentifikasi:

- `routes/web.php`
- `routes/auth.php`
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php`
- `app/Http/Requests/Auth/LoginRequest.php`
- `app/Http/Controllers/CommentController.php`
- `app/Http/Controllers/SubmissionController.php`
- `app/Models/Comment.php`
- `app/Models/Submission.php`
- `database/migrations/2026_06_12_150614_create_comments_table.php`
- `database/migrations/2026_06_12_150613_create_submissions_table.php`
- `resources/views/layouts/public.blade.php`
- `resources/views/auth/login.blade.php`
- `resources/views/pages/courses/lesson.blade.php`
- `resources/views/admin/submissions/index.blade.php`

Masalah utama di kondisi saat ini:

- `routes/auth.php` masih menyediakan route `login`, `register`, forgot password, reset password, dan email verification.
- `resources/views/layouts/public.blade.php` masih menampilkan tombol `Log in` dan `Daftar`.
- Route `comments.store` dan `submissions.store` masih berada di dalam middleware `auth`.
- `CommentController` menyimpan `user_id` dari `auth()->id()`.
- `SubmissionController` menyimpan `user_id` dari `auth()->id()` dan memakai `updateOrCreate` berdasarkan `assignment_id + user_id`.
- Tabel `comments` dan `submissions` mewajibkan `user_id`, sehingga belum cocok untuk guest/anonymous public user.
- View lesson masih memakai `@auth` untuk menampilkan form komentar dan form upload tugas.
- Admin submission list masih membaca nama dari relasi `$submission->user->name`.

## Keputusan Implementasi

Gunakan pendekatan berikut agar perubahan sederhana dan tidak mengganggu data lama:

1. Admin tetap memakai tabel `users` dan guard `web`.
2. Login admin memakai controller auth yang sudah ada, tetapi route login dipindah ke `/sudut-panel/admin/login`.
3. Route login admin tetap diberi nama `login` supaya middleware `auth` Laravel tetap bisa redirect ke route login yang valid.
4. Register user publik dihapus dari route dan UI.
5. Komentar guest disimpan di tabel `comments` dengan kolom baru `guest_name`.
6. Pengumpulan tugas guest disimpan di tabel `submissions` dengan kolom baru `student_name`.
7. Kolom `user_id` pada `comments` dan `submissions` dibuat nullable agar data lama dari user/admin tetap bisa dipertahankan.
8. Untuk submission tanpa login, buat record baru setiap kali submit. Jangan pakai `updateOrCreate` berdasarkan nama karena dua orang bisa memiliki nama yang sama.

## Tahap 1: Audit Auth dan Route Publik

Tujuan tahap ini adalah memastikan semua titik masuk login/register user biasa ditemukan sebelum dihapus.

Yang harus dilakukan:

1. Buka `routes/web.php` dan `routes/auth.php`.
2. Catat semua route yang memakai middleware `auth`.
3. Pastikan route berikut tidak lagi membutuhkan login user:
   - `POST /assignments/{assignment}/submit`
   - `POST /courses/{course}/comments`
4. Pastikan route admin tetap dilindungi middleware:
   - `auth`
   - `admin`
5. Cari semua pemakaian route berikut:
   - `route('login')`
   - `route('register')`
   - `Route::has('register')`
   - `@auth`
   - `@guest`

Command yang bisa dipakai:

```bash
rg "route\\('login'\\)|route\\('register'\\)|Route::has\\('register'\\)|@auth|@guest" routes resources app
```

Output tahap ini:

- Daftar file yang perlu diubah.
- Tidak ada implementasi dulu sebelum route dan view yang terdampak terpetakan.

## Tahap 2: Ubah Route Login Menjadi Khusus Admin

Tujuan tahap ini adalah menghapus login/register user publik dan mempertahankan login admin di URL tersembunyi.

Yang harus dilakukan:

1. Edit `routes/auth.php`.
2. Hapus/nonaktifkan route register:
   - `GET /register`
   - `POST /register`
3. Hapus route auth publik yang tidak diperlukan user biasa:
   - forgot password
   - reset password
   - email verification
   - confirm password
   - password update
4. Pertahankan hanya route login dan logout yang diperlukan admin.
5. Ubah route login menjadi:

```php
Route::middleware('guest')->group(function () {
    Route::get('/sudut-panel/admin/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('/sudut-panel/admin/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
```

Catatan penting:

- Nama route login sebaiknya tetap `login`.
- Ini membuat middleware `auth` tetap otomatis redirect ke `/sudut-panel/admin/login`.
- Jangan membuat route `/login` publik lagi.
- Jika ada test lama yang mengharapkan `/login`, test tersebut harus diperbarui sesuai requirement baru.

Output tahap ini:

- `/login` tidak tersedia.
- `/register` tidak tersedia.
- `/sudut-panel/admin/login` menampilkan form login.
- Admin masih bisa logout lewat route `logout`.

## Tahap 3: Batasi Login Hanya Untuk Admin

Tujuan tahap ini adalah memastikan akun non-admin tidak bisa masuk walaupun masih ada record user lama di database.

Yang harus dilakukan:

1. Buka `app/Http/Controllers/Auth/AuthenticatedSessionController.php`.
2. Setelah `$request->authenticate()` dan session regenerate, cek role user.
3. Jika role bukan `admin`:
   - logout user tersebut.
   - invalidate session.
   - kembalikan ke form login dengan error.
4. Jika role `admin`, redirect ke `admin.dashboard`.

Contoh arah implementasi:

```php
if ($request->user()->role !== 'admin') {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return back()->withErrors([
        'email' => 'Akun ini tidak memiliki akses admin.',
    ])->onlyInput('email');
}

return redirect()->route('admin.dashboard');
```

Hal lain yang perlu diubah:

1. Update copywriting di `resources/views/auth/login.blade.php` agar jelas ini adalah login admin, bukan login belajar user.
2. Hapus link `Daftar di sini` dari halaman login admin.
3. Hapus link lupa sandi jika route password reset dihapus.

Output tahap ini:

- Hanya admin yang bisa login.
- Non-admin tidak bisa masuk.
- Form login tidak lagi mengajak user biasa untuk daftar.

## Tahap 4: Bersihkan UI Publik Dari Login dan Register

Tujuan tahap ini adalah memastikan pengunjung website tidak melihat tombol login/register user.

Yang harus dilakukan:

1. Edit `resources/views/layouts/public.blade.php`.
2. Hapus blok tombol berikut untuk guest:
   - `Log in`
   - `Daftar`
3. Untuk kondisi `@auth` admin, boleh tetap tampilkan:
   - `Admin Panel`
   - `Keluar`
4. Untuk guest, navbar cukup menampilkan navigasi publik:
   - Beranda
   - Kursus
   - Tentang Kami
   - Kontak
5. Pastikan tidak ada link public yang mengarah ke `route('login')` atau `route('register')`.

Command verifikasi:

```bash
rg "route\\('login'\\)|route\\('register'\\)|Route::has\\('register'\\)" resources routes
```

Output tahap ini:

- Navbar publik bersih dari login/register.
- URL admin login tidak dipromosikan di UI publik.

## Tahap 5: Ubah Database Agar Komentar Bisa Tanpa User Login

Tujuan tahap ini adalah membuat komentar bisa disimpan tanpa `user_id`.

Yang harus dilakukan:

1. Buat migration baru, jangan mengubah migration lama jika database sudah pernah dimigrate.
2. Tambahkan kolom `guest_name` pada tabel `comments`.
3. Ubah `user_id` menjadi nullable.

Contoh struktur migration:

```php
Schema::table('comments', function (Blueprint $table) {
    $table->string('guest_name')->nullable()->after('user_id');
    $table->foreignId('user_id')->nullable()->change();
});
```

Catatan:

- Jika `change()` bermasalah karena constraint foreign key, drop foreign key dulu lalu buat ulang dengan `nullable`.
- Untuk data komentar lama, `user_id` tetap ada dan tidak perlu dipindahkan.
- Untuk komentar baru dari guest, `guest_name` wajib diisi lewat validasi controller.

Output tahap ini:

- Tabel `comments` punya kolom `guest_name`.
- Komentar bisa dibuat tanpa `user_id`.

## Tahap 6: Ubah Database Agar Submission Bisa Tanpa User Login

Tujuan tahap ini adalah membuat pengumpulan tugas bisa disimpan tanpa `user_id`.

Yang harus dilakukan:

1. Buat migration baru.
2. Tambahkan kolom `student_name` pada tabel `submissions`.
3. Ubah `user_id` menjadi nullable.

Contoh struktur migration:

```php
Schema::table('submissions', function (Blueprint $table) {
    $table->string('student_name')->nullable()->after('user_id');
    $table->foreignId('user_id')->nullable()->change();
});
```

Catatan:

- Jika constraint foreign key menghalangi `change()`, drop foreign key dulu lalu buat ulang.
- `student_name` dibuat nullable untuk menjaga kompatibilitas data lama.
- Validasi controller harus mewajibkan `student_name` untuk submission baru dari guest.

Output tahap ini:

- Tabel `submissions` punya kolom `student_name`.
- Submission bisa dibuat tanpa `user_id`.

## Tahap 7: Update Model Comment dan Submission

Tujuan tahap ini adalah mengizinkan mass assignment untuk kolom baru dan menyediakan fallback nama.

Yang harus dilakukan pada `app/Models/Comment.php`:

1. Tambahkan `guest_name` ke `$fillable`.
2. Pastikan relasi `user()` tetap ada.
3. Jika ingin rapi, tambahkan accessor untuk nama penampil:

```php
public function getAuthorNameAttribute(): string
{
    return $this->user?->name ?? $this->guest_name ?? 'Pengunjung';
}
```

Yang harus dilakukan pada `app/Models/Submission.php`:

1. Tambahkan `student_name` ke `$fillable`.
2. Pastikan relasi `user()` tetap ada.
3. Jika ingin rapi, tambahkan accessor:

```php
public function getStudentDisplayNameAttribute(): string
{
    return $this->user?->name ?? $this->student_name ?? 'Pengunjung';
}
```

Output tahap ini:

- View bisa membaca nama tanpa harus selalu ada relasi user.
- Data lama dan data baru tetap bisa tampil.

## Tahap 8: Pindahkan Route Komentar dan Submission Keluar Dari Middleware Auth

Tujuan tahap ini adalah membuat form komentar dan upload tugas bisa dikirim oleh guest.

Yang harus dilakukan:

1. Edit `routes/web.php`.
2. Pindahkan route berikut keluar dari `Route::middleware('auth')->group(...)`:

```php
Route::post('/assignments/{assignment}/submit', [SubmissionController::class, 'store'])
    ->name('submissions.store');

Route::post('/courses/{course}/comments', [CommentController::class, 'store'])
    ->name('comments.store');
```

3. Sisakan route profile di dalam middleware `auth` jika masih diperlukan untuk admin, atau hapus route profile jika fitur profile tidak lagi dipakai.
4. Route admin tetap di dalam middleware `auth` dan `admin`.

Output tahap ini:

- Guest bisa submit komentar.
- Guest bisa upload tugas.
- Admin panel tetap terlindungi.

## Tahap 9: Update Controller Komentar

Tujuan tahap ini adalah menyimpan komentar dari guest dengan nama manual.

Yang harus dilakukan pada `app/Http/Controllers/CommentController.php`:

1. Tambahkan validasi `guest_name`.
2. Tetap validasi `body`.
3. Tetap validasi `parent_id`.
4. Simpan `user_id` hanya jika ada user login.
5. Simpan `guest_name` dari input.

Contoh arah implementasi:

```php
$data = $request->validate([
    'guest_name' => 'required|string|min:2|max:100',
    'body' => 'required|string|min:3|max:1000',
    'parent_id' => 'nullable|exists:comments,id',
]);

$data['course_id'] = $course->id;
$data['user_id'] = auth()->id();
$data['status'] = 'visible';

Comment::create($data);
```

Catatan:

- Jika admin sedang login lalu ikut komentar, boleh tetap isi `user_id`.
- Untuk guest, `user_id` akan `null`.
- Untuk reply komentar, `guest_name` juga tetap wajib supaya balasan punya nama.

Output tahap ini:

- Komentar guest tersimpan dengan nama.
- Komentar lama milik user/admin tetap bisa tampil.

## Tahap 10: Update Controller Pengumpulan Tugas

Tujuan tahap ini adalah menyimpan submission dari guest dengan nama manual.

Yang harus dilakukan pada `app/Http/Controllers/SubmissionController.php`:

1. Tambahkan validasi `student_name`.
2. Tetap validasi file PDF.
3. Tetap cek `is_active`.
4. Tetap cek `due_at`.
5. Simpan file ke storage seperti sekarang.
6. Ganti `updateOrCreate` menjadi `Submission::create`.

Contoh arah implementasi:

```php
$data = $request->validate([
    'student_name' => 'required|string|min:2|max:100',
    'submission_file' => 'required|file|mimes:pdf|max:10240',
]);

$path = $request->file('submission_file')->store('submissions', 'public');

Submission::create([
    'assignment_id' => $assignment->id,
    'user_id' => auth()->id(),
    'student_name' => $data['student_name'],
    'file_path' => $path,
    'status' => 'pending',
    'submitted_at' => now(),
]);
```

Catatan:

- Jangan pakai nama sebagai pengganti identitas unik.
- Jika dua orang bernama sama mengumpulkan tugas, keduanya harus tetap tercatat.
- Jika ingin mencegah spam, buat task terpisah untuk rate limit/captcha.

Output tahap ini:

- Guest bisa mengumpulkan tugas dengan nama dan file.
- Setiap submit menghasilkan record submission baru.

## Tahap 11: Update View Lesson Untuk Form Guest

Tujuan tahap ini adalah menghapus blok login required dari halaman lesson.

Yang harus dilakukan pada `resources/views/pages/courses/lesson.blade.php`:

### Bagian Tugas

1. Hapus wrapper `@auth` dan `@else` yang menampilkan pesan login.
2. Selalu tampilkan form upload jika assignment aktif dan belum lewat tenggat.
3. Tambahkan input nama:

```blade
<input type="text" name="student_name" value="{{ old('student_name') }}" required>
```

4. Tampilkan error validasi untuk:
   - `student_name`
   - `submission_file`
5. Hapus pengecekan submission berdasarkan `auth()->id()` karena guest tidak punya identity.
6. Setelah submit, cukup tampilkan flash message sukses.

Catatan UI:

- Karena tidak ada login, halaman tidak bisa tahu submission sebelumnya milik siapa.
- Jangan tampilkan status `Tugas Dikumpulkan` berbasis user login.
- Admin tetap bisa melihat semua submission di panel admin.

### Bagian Komentar

1. Hapus wrapper `@auth` dan `@else` pada form komentar.
2. Selalu tampilkan form komentar.
3. Tambahkan input nama:

```blade
<input type="text" name="guest_name" value="{{ old('guest_name') }}" required>
```

4. Textarea `body` tetap wajib.
5. Tombol `Balas` dan form reply juga tidak boleh dibatasi `@auth`.
6. Form reply juga harus punya input `guest_name`.
7. Saat menampilkan nama komentar, gunakan:
   - `$comment->author_name` jika accessor dibuat, atau
   - `$comment->user?->name ?? $comment->guest_name ?? 'Pengunjung'`
8. Saat menampilkan avatar inisial, ambil dari nama fallback yang sama.
9. Saat menampilkan reply, gunakan fallback nama yang sama.

Output tahap ini:

- Pengunjung bisa komentar tanpa login.
- Pengunjung bisa membalas komentar tanpa login.
- Tidak ada link login di area komentar atau tugas.

## Tahap 12: Update Admin Submission List

Tujuan tahap ini adalah admin tetap bisa melihat nama pengumpul tugas walaupun tidak ada `user_id`.

Yang harus dilakukan pada `resources/views/admin/submissions/index.blade.php`:

1. Ganti semua `$submission->user->name` menjadi fallback:

```blade
{{ $submission->user?->name ?? $submission->student_name ?? 'Pengunjung' }}
```

2. Untuk inisial avatar, gunakan nama fallback yang sama.
3. Untuk modal review, kirim nama fallback ke JavaScript.
4. Pastikan view tidak error saat `user_id` null.

Yang harus dilakukan pada `app/Http/Controllers/Admin/SubmissionController.php`:

1. `with('user')` boleh tetap dipakai.
2. Pastikan sorting tetap berdasarkan submission terbaru.

Catatan tambahan:

- Controller admin saat ini memvalidasi `grade`, tetapi migration memakai kolom `score`.
- Saat implementasi, cek apakah database benar-benar punya kolom `grade` atau `score`.
- Jika hanya ada `score`, samakan controller dan view agar memakai `score`.
- Ini bukan requirement utama, tetapi bisa menyebabkan fitur review admin error.

Output tahap ini:

- Admin bisa melihat semua tugas guest.
- Admin tidak mendapat error karena relasi user null.

## Tahap 13: Update Query Loading Komentar Jika Diperlukan

Tujuan tahap ini adalah memastikan relasi nullable tidak menyebabkan N+1 atau error.

Yang harus dicek:

1. Buka `app/Http/Controllers/PublicCourseController.php`.
2. Cari query komentar untuk halaman lesson/course.
3. Pastikan query eager load relasi:
   - `user`
   - `replies.user`
4. Jika view memakai accessor, pastikan tetap aman saat `user` null.

Output tahap ini:

- Komentar dan reply tampil stabil untuk user lama maupun guest baru.

## Tahap 14: Bersihkan File Auth yang Tidak Dipakai

Tujuan tahap ini adalah mengurangi route mati dan link rusak.

Yang harus dilakukan:

1. Setelah route register/password reset dihapus, cari view yang masih merujuk ke route tersebut.
2. Minimal hapus link dari:
   - `resources/views/auth/login.blade.php`
   - `resources/views/layouts/public.blade.php`
3. File controller auth yang tidak dipakai boleh dibiarkan agar perubahan tidak terlalu besar:
   - `RegisteredUserController`
   - `PasswordResetLinkController`
   - `NewPasswordController`
   - dan sejenisnya
4. Jangan hapus file auth controller kecuali sudah dipastikan tidak mengganggu autoload/test.

Output tahap ini:

- Tidak ada link publik ke register/reset password.
- Tidak ada route auth user biasa yang aktif.

## Tahap 15: Update Test

Tujuan tahap ini adalah memastikan requirement baru terjaga.

Test yang perlu ditambah atau diubah:

1. Test `/login` tidak tersedia atau tidak lagi menjadi halaman login user.
2. Test `/register` tidak tersedia.
3. Test `GET /sudut-panel/admin/login` menampilkan halaman login admin.
4. Test admin bisa login dari `/sudut-panel/admin/login`.
5. Test user non-admin tidak bisa login.
6. Test guest bisa membuat komentar dengan `guest_name` dan `body`.
7. Test guest bisa upload submission dengan `student_name` dan file PDF.
8. Test halaman lesson tidak menampilkan link login untuk komentar/tugas.
9. Test admin submission list bisa render submission yang `user_id` null.

File test lama yang kemungkinan perlu disesuaikan:

- `tests/Feature/Auth/AuthenticationTest.php`
- `tests/Feature/Auth/RegistrationTest.php`
- `tests/Feature/Auth/PasswordResetTest.php`
- `tests/Feature/Auth/EmailVerificationTest.php`
- `tests/Feature/ProfileTest.php`

Catatan:

- Karena requirement baru menghapus user login/register, test bawaan Laravel Breeze untuk register/password reset kemungkinan sudah tidak relevan.
- Jangan mempertahankan test lama jika bertentangan dengan requirement baru.

## Tahap 16: Manual QA

Lakukan pengecekan manual setelah implementasi.

Checklist publik:

- Buka `/`.
- Pastikan tidak ada tombol `Log in` dan `Daftar`.
- Buka `/courses`.
- Buka detail course.
- Buka halaman lesson.
- Pastikan form komentar langsung terlihat.
- Submit komentar dengan nama dan isi komentar.
- Pastikan komentar tampil dengan nama yang diinput.
- Balas komentar dengan nama lain.
- Pastikan reply tampil dengan nama yang diinput.
- Upload tugas dengan nama dan file PDF.
- Pastikan muncul pesan sukses.
- Pastikan tidak ada ajakan login di area tugas.

Checklist admin:

- Buka `/sudut-panel/admin/login`.
- Login sebagai admin.
- Pastikan redirect ke admin dashboard.
- Buka daftar submission assignment.
- Pastikan submission guest tampil dengan nama.
- Klik review/beri nilai.
- Pastikan modal tidak error saat submission tidak punya user.
- Logout admin.
- Pastikan setelah logout kembali ke halaman publik.

Checklist route yang harus tidak aktif:

- `/login`
- `/register`
- `/forgot-password`
- `/reset-password/...`

## Risiko dan Hal yang Perlu Diwaspadai

1. Middleware `auth` Laravel biasanya redirect ke route bernama `login`. Karena itu route `/sudut-panel/admin/login` sebaiknya tetap bernama `login`.
2. Jika `user_id` dibuat nullable, semua view yang memakai `$comment->user->name` atau `$submission->user->name` harus diubah menjadi null-safe.
3. Submission guest tidak punya identity permanen. Jangan tampilkan status "sudah mengumpulkan" berdasarkan session login.
4. Input nama public rawan spam atau impersonation. Jika nanti dibutuhkan, buat issue terpisah untuk captcha, rate limit, atau moderation.
5. Jika route password reset dihapus, admin yang lupa password tidak bisa reset mandiri. Pastikan ada cara admin reset password lewat seeder, tinker, atau panel server.
6. Existing test auth bawaan Laravel kemungkinan gagal dan harus disesuaikan dengan requirement baru.

## Definition of Done

Implementasi dianggap selesai jika:

1. Tidak ada login/register untuk user biasa di UI publik.
2. `/login` dan `/register` tidak lagi menjadi route user publik.
3. Admin login tersedia di `/sudut-panel/admin/login`.
4. Hanya akun role `admin` yang bisa login.
5. Guest bisa membuat komentar dengan nama.
6. Guest bisa membalas komentar dengan nama.
7. Guest bisa mengumpulkan tugas dengan nama dan file PDF.
8. Admin bisa melihat submission guest tanpa error.
9. Test terkait requirement baru lulus.
10. Tidak ada error karena `user_id` null pada komentar atau submission.

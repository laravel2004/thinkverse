# context.md — Learning CMS Laravel Blade + TailwindCSS

## 1. Ringkasan Project

Project ini adalah **web CMS pembelajaran** berbasis **Laravel, Blade, dan TailwindCSS**. Tujuan utamanya adalah menyediakan website pembelajaran publik yang modern, rapi, mudah dikelola, dan nyaman digunakan oleh pengunjung maupun admin.

Website memiliki dua sisi utama:

1. **Public learning website**
   - Landing page modern.
   - Profil pemilik / pengajar.
   - Daftar course yang tersedia.
   - Halaman detail course.
   - Halaman belajar dengan navigasi bab dan sub-bab.
   - Konten pembelajaran yang kaya: teks WYSIWYG, embed YouTube, link, tombol, card buku, file pendukung, komentar, dan pengumpulan tugas.

2. **CMS admin**
   - Mengelola course.
   - Mengelola struktur bab dan sub-bab bertingkat.
   - Mengelola konten pembelajaran.
   - Mengelola komentar.
   - Mengelola pengumpulan tugas.
   - Mengelola profil pemilik website.
   - Mengelola aset visual seperti thumbnail course, cover, buku, dan lampiran.

Project ini harus terasa seperti platform pembelajaran modern, bukan sekadar dashboard CRUD biasa.

---

## 2. Tech Stack

Gunakan stack berikut sebagai acuan utama:

- **Backend:** Laravel
- **Frontend server-rendered:** Blade
- **Styling:** TailwindCSS
- **Interactivity ringan:** Alpine.js bila diperlukan
- **Database:** MySQL atau PostgreSQL
- **Auth:** Laravel Breeze / Laravel UI / auth sederhana Laravel, disesuaikan dengan setup project
- **Editor konten:** WYSIWYG editor seperti Trix, TipTap, TinyMCE, atau CKEditor
- **Upload file:** Laravel Storage
- **Build tool:** Vite

Hindari menambahkan dependency pihak ketiga tanpa alasan kuat. Jika fitur bisa dibuat dengan Laravel, Blade, Tailwind, dan Alpine.js, prioritaskan pendekatan sederhana tersebut.

---

## 3. Visual Direction

Arah visual mengikuti gaya website pembelajaran modern dengan tone **ungu**, elegan, bersih, dan ramah.

### Karakter desain

- Modern
- Soft
- Edukatif
- Premium ringan
- Tidak terlalu ramai
- Mudah dibaca
- Cocok untuk personal brand pengajar / pemilik website

### Warna utama

Gunakan palet ungu sebagai identitas utama.

Contoh arah warna:

- Primary: `violet-600`, `purple-600`, atau custom purple
- Secondary: `indigo-500`
- Background: `slate-50`, `white`, atau gradient lembut
- Text utama: `slate-900`
- Text sekunder: `slate-600`
- Border: `slate-200`
- Accent: `fuchsia-500` atau `amber-400` secukupnya

### Komponen visual utama

- Hero section dengan headline kuat.
- Card course modern dengan thumbnail, badge level/kategori, progress opsional.
- Section profil pemilik website.
- Section benefit / alasan belajar.
- Layout learning page dua kolom:
  - Sidebar kiri untuk daftar bab dan sub-bab.
  - Main content kanan untuk isi pembelajaran.
- Card, modal, accordion, badge, dan button harus konsisten.

---

## 4. Target Pengguna

### Public visitor

Pengunjung umum yang melihat landing page, membaca profil, dan melihat course yang tersedia.

### Learner / peserta

Pengguna yang membuka course, membaca materi, memberi komentar, dan mengumpulkan tugas jika fitur tersebut diaktifkan.

### Admin / pengelola

Pengguna yang mengelola semua data pembelajaran melalui CMS.

---

## 5. Fitur Utama

### 5.1 Landing Page

Landing page harus menampilkan:

- Navbar
- Hero section
- Profil pemilik / pengajar
- Highlight course
- Keunggulan platform
- Testimoni opsional
- CTA untuk mulai belajar
- Footer

Landing page harus terasa menarik dan modern, bukan sekadar daftar course.

---

### 5.2 Course

Course adalah unit utama pembelajaran.

Setiap course minimal memiliki:

- Judul
- Slug
- Deskripsi singkat
- Deskripsi lengkap
- Thumbnail / cover
- Kategori
- Level
- Status publikasi
- Urutan tampil
- Informasi pengajar / pemilik
- Estimasi durasi opsional

Public user dapat melihat daftar course dan membuka detail course.

Admin dapat membuat, mengedit, menghapus, mengurutkan, dan mempublikasikan course.

---

### 5.3 Bab dan Sub-Bab Bertingkat

Setiap course memiliki struktur materi yang terdiri dari bab dan sub-bab.

Struktur ini harus mendukung nesting / hierarki bertingkat.

Contoh:

- Bab 1: Pengenalan
  - Sub-bab 1.1: Apa itu topik ini?
  - Sub-bab 1.2: Konsep dasar
    - Sub-bab 1.2.1: Contoh lanjutan
- Bab 2: Praktik
  - Sub-bab 2.1: Studi kasus
  - Sub-bab 2.2: Latihan

Gunakan model yang mendukung `parent_id`, `course_id`, dan `sort_order`.

Sidebar pembelajaran harus bisa menampilkan tree bab dan sub-bab secara rapi.

---

### 5.4 Konten Pembelajaran

Konten utama pembelajaran berasal dari WYSIWYG editor dan dapat berisi beberapa tipe komponen.

Tipe konten yang perlu didukung:

- Rich text
- Heading
- Paragraph
- Image
- Embed YouTube
- Text link
- Button link
- Card buku
- File lampiran
- Quote / highlight box
- Checklist opsional

Ada dua pendekatan yang bisa dipilih:

1. **Pendekatan sederhana**
   - Simpan HTML hasil WYSIWYG ke field `content`.
   - Cocok untuk MVP.
   - Perlu sanitasi output agar aman.

2. **Pendekatan content blocks**
   - Simpan konten sebagai blok-blok terstruktur.
   - Cocok untuk CMS yang lebih fleksibel.
   - Misalnya: `lesson_blocks` dengan tipe `rich_text`, `youtube`, `button_link`, `book_card`, dan seterusnya.

Untuk tahap awal, prioritaskan implementasi yang sederhana namun mudah dikembangkan.

---

### 5.5 Komentar

Di bagian bawah konten pembelajaran, tersedia fitur komentar.

Komentar dapat digunakan untuk:

- Tanya jawab peserta.
- Diskusi materi.
- Feedback terhadap pembelajaran.

Aturan dasar:

- Komentar dikaitkan dengan lesson / bab tertentu.
- User harus login untuk berkomentar.
- Admin dapat melihat, menyembunyikan, atau menghapus komentar.
- Komentar dapat memiliki status seperti `visible`, `hidden`, atau `pending`.

---

### 5.6 Pengumpulan Tugas

Pada lesson tertentu, admin dapat mengaktifkan fitur pengumpulan tugas.

Tugas bisa berupa:

- Jawaban teks.
- Upload file.
- Link eksternal.
- Kombinasi teks dan file.

Aturan dasar:

- Pengumpulan tugas bersifat opsional per lesson.
- User harus login untuk mengumpulkan tugas.
- Admin dapat melihat daftar submission.
- Admin dapat memberi status, feedback, atau nilai opsional.
- File harus divalidasi ukuran dan tipenya.

---

## 6. CMS Admin

CMS admin harus fokus pada kemudahan pengelolaan konten.

Menu utama admin:

- Dashboard
- Courses
- Bab / Lessons
- Comments
- Submissions
- Books / Resources
- Profile
- Settings

Prinsip CMS:

- CRUD harus rapi dan konsisten.
- Form harus mudah dipahami.
- Gunakan komponen Blade reusable untuk input, textarea, select, image upload, status badge, table, pagination, dan action button.
- Jangan membuat halaman admin terlalu ramai.
- Prioritaskan workflow pengelolaan course dan lesson.

---

## 7. Data Model Awal

Struktur tabel dapat dimulai dari model berikut.

### users

Menggunakan tabel user bawaan Laravel.

Tambahan field opsional:

- `role`
- `avatar`
- `bio`

Role awal:

- `admin`
- `learner`

### courses

Field utama:

- `id`
- `title`
- `slug`
- `excerpt`
- `description`
- `thumbnail_path`
- `category`
- `level`
- `status`
- `sort_order`
- `published_at`
- `created_at`
- `updated_at`

### lessons

Field utama:

- `id`
- `course_id`
- `parent_id`
- `title`
- `slug`
- `excerpt`
- `content`
- `status`
- `sort_order`
- `is_task_enabled`
- `task_instruction`
- `created_at`
- `updated_at`

Catatan:

- `parent_id` digunakan agar lesson bisa menjadi bab atau sub-bab.
- Untuk URL publik, lesson tetap berada di bawah course.

### lesson_blocks

Opsional untuk pendekatan content block.

Field utama:

- `id`
- `lesson_id`
- `type`
- `payload`
- `sort_order`
- `created_at`
- `updated_at`

### comments

Field utama:

- `id`
- `lesson_id`
- `user_id`
- `parent_id`
- `body`
- `status`
- `created_at`
- `updated_at`

### submissions

Field utama:

- `id`
- `lesson_id`
- `user_id`
- `body`
- `file_path`
- `external_link`
- `status`
- `score`
- `feedback`
- `submitted_at`
- `created_at`
- `updated_at`

### books / resources

Field utama:

- `id`
- `title`
- `slug`
- `author`
- `description`
- `cover_path`
- `target_url`
- `created_at`
- `updated_at`

### site_profiles

Field utama:

- `id`
- `owner_name`
- `headline`
- `bio`
- `photo_path`
- `social_links`
- `created_at`
- `updated_at`

---

## 8. Routing Awal

### Public routes

Contoh route publik:

- `GET /`
- `GET /courses`
- `GET /courses/{course:slug}`
- `GET /courses/{course:slug}/lessons/{lesson:slug}`
- `POST /lessons/{lesson}/comments`
- `POST /lessons/{lesson}/submissions`

### Admin routes

Gunakan prefix admin:

- `GET /admin`
- `GET /admin/courses`
- `POST /admin/courses`
- `GET /admin/courses/{course}/edit`
- `PUT /admin/courses/{course}`
- `DELETE /admin/courses/{course}`

- `GET /admin/courses/{course}/lessons`
- `POST /admin/courses/{course}/lessons`
- `GET /admin/lessons/{lesson}/edit`
- `PUT /admin/lessons/{lesson}`
- `DELETE /admin/lessons/{lesson}`

- `GET /admin/comments`
- `PATCH /admin/comments/{comment}`

- `GET /admin/submissions`
- `GET /admin/submissions/{submission}`
- `PATCH /admin/submissions/{submission}`

---

## 9. Blade Structure

Gunakan struktur Blade yang rapi.

Contoh:

```text
resources/views/
├── layouts/
│   ├── app.blade.php
│   ├── public.blade.php
│   └── admin.blade.php
├── components/
│   ├── button.blade.php
│   ├── badge.blade.php
│   ├── card.blade.php
│   ├── form/
│   └── learning/
├── pages/
│   ├── home.blade.php
│   ├── courses/
│   └── lessons/
└── admin/
    ├── dashboard.blade.php
    ├── courses/
    ├── lessons/
    ├── comments/
    └── submissions/
```

Gunakan Blade component untuk UI yang sering diulang.

---

## 10. TailwindCSS Guidelines

Gunakan Tailwind secara konsisten.

Prinsip:

- Hindari class yang terlalu acak.
- Buat komponen Blade untuk pattern yang berulang.
- Gunakan spacing konsisten.
- Gunakan responsive design dari awal.
- Fokus pada readability.

Breakpoint:

- Mobile first.
- Sidebar learning page bisa menjadi drawer / accordion di mobile.
- Desktop menggunakan layout dua kolom.

Contoh style umum:

```html
<section class="bg-gradient-to-br from-violet-50 via-white to-fuchsia-50">
    <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        ...
    </div>
</section>
```

---

## 11. Laravel Coding Conventions

Ikuti prinsip berikut:

- Gunakan controller tipis.
- Pindahkan logic kompleks ke service class.
- Gunakan Form Request untuk validasi.
- Gunakan policy / middleware untuk akses admin.
- Gunakan Eloquent relationship dengan jelas.
- Gunakan route model binding.
- Gunakan pagination untuk list besar.
- Gunakan transaction untuk operasi yang menyimpan banyak data.
- Gunakan storage disk untuk upload.

Contoh service yang mungkin dibutuhkan:

- `CourseService`
- `LessonTreeService`
- `ContentSanitizerService`
- `SubmissionService`
- `CommentModerationService`

---

## 12. Security Guidelines

Hal penting:

- Validasi semua input.
- Sanitasi HTML dari WYSIWYG.
- Batasi file upload berdasarkan mime type dan ukuran.
- Jangan render HTML mentah tanpa sanitasi.
- Gunakan authorization untuk admin route.
- Gunakan CSRF protection bawaan Laravel.
- Jangan menyimpan secret di repository.
- Gunakan `.env` untuk konfigurasi.
- Pastikan slug unik.
- Hindari mass assignment tanpa `$fillable` yang jelas.

---

## 13. SEO dan Accessibility

Public page harus memperhatikan:

- Title dan meta description.
- Heading hierarchy yang benar.
- Alt text untuk gambar.
- Link dan button yang jelas.
- Kontras warna cukup.
- Layout mobile friendly.
- URL yang bersih dan readable.
- Open Graph tags opsional.

---

## 14. Testing dan Quality

Minimal lakukan:

- Feature test untuk public pages.
- Feature test untuk admin CRUD utama.
- Validation test untuk course, lesson, comment, dan submission.
- Authorization test untuk admin routes.
- Test upload file jika fitur submission aktif.

Sebelum menyelesaikan task, jalankan:

```bash
php artisan test
npm run build
```

Jika project menggunakan formatter atau linter, jalankan juga sesuai setup project.

---

## 15. Development Phase

### Phase 1 — Foundation

- Setup Laravel auth.
- Setup layout public dan admin.
- Setup Tailwind theme.
- Buat model, migration, factory, seeder awal.
- Buat landing page statis.

### Phase 2 — Course CMS

- CRUD course.
- Public course list.
- Public course detail.
- Thumbnail upload.
- Publish / draft status.

### Phase 3 — Lesson Tree

- CRUD lesson.
- Parent-child lesson.
- Sorting.
- Sidebar tree di halaman belajar.
- Public lesson detail.

### Phase 4 — Rich Content

- Integrasi WYSIWYG.
- Render konten lesson.
- Embed YouTube.
- Link/button block.
- Book/resource card.

### Phase 5 — Interaction

- Komentar.
- Pengumpulan tugas.
- Admin moderation.
- Admin submission review.

### Phase 6 — Polish

- Responsive improvement.
- Empty state.
- Loading state.
- SEO.
- Accessibility.
- Testing.
- Performance cleanup.

---

## 16. Definition of Done

Sebuah task dianggap selesai jika:

- Fitur berjalan sesuai requirement.
- UI konsisten dengan visual direction.
- Tidak ada error obvious di Blade, route, dan controller.
- Validasi input tersedia.
- Authorization diperhatikan.
- Data model dan relationship rapi.
- Tidak ada dependency baru tanpa alasan jelas.
- Test relevan ditambahkan atau diperbarui.
- `php artisan test` dan `npm run build` aman dijalankan.

# .agents/skill/cms-learning-laravel-blade-tailwind.md

## Skill Name

Learning CMS — Laravel Blade TailwindCSS

## Purpose

Gunakan skill ini saat mengerjakan project CMS pembelajaran berbasis Laravel, Blade, dan TailwindCSS.

Skill ini membantu agent menghasilkan kode yang:

- Rapi
- Konsisten
- Mudah dipahami
- Aman
- Sesuai pattern Laravel
- Cocok untuk CMS pembelajaran
- Tidak terlalu rumit untuk kebutuhan awal project

Project ini bukan SPA penuh. Prioritaskan server-rendered page dengan Blade dan TailwindCSS. Gunakan Alpine.js hanya untuk interaksi ringan seperti dropdown, accordion, modal, nested sidebar, image preview, dan toggle.

---

## When to Use This Skill

Gunakan skill ini untuk task seperti:

- Membuat atau memperbaiki landing page.
- Membuat CMS admin.
- Membuat CRUD course.
- Membuat CRUD lesson / bab / sub-bab.
- Membuat nested lesson tree.
- Membuat halaman belajar.
- Membuat fitur WYSIWYG content.
- Membuat embed YouTube, button link, text link, card buku, atau content block.
- Membuat komentar.
- Membuat pengumpulan tugas.
- Memperbaiki UI TailwindCSS.
- Merapikan struktur Blade component.
- Menambah migration, model, controller, request, policy, seeder, atau test.

---

## Project Understanding

Project ini adalah web CMS pembelajaran.

Ada dua area:

1. Public website
   - Landing page
   - Course listing
   - Course detail
   - Lesson reader
   - Comment section
   - Submission section

2. Admin CMS
   - Dashboard
   - Course management
   - Lesson management
   - Comment moderation
   - Submission review
   - Resource/book management
   - Site profile/settings

Website harus memiliki nuansa modern dengan warna utama ungu. UI harus terasa seperti platform belajar, bukan hanya panel CRUD sederhana.

---

## Core Product Rules

### Course

Course adalah kumpulan materi pembelajaran.

Course harus memiliki:

- title
- slug
- excerpt
- description
- thumbnail_path
- category
- level
- status
- sort_order
- published_at

Course public hanya menampilkan item yang statusnya published.

### Lesson

Lesson merepresentasikan bab atau sub-bab.

Lesson harus mendukung struktur hierarki menggunakan `parent_id`.

Field utama:

- course_id
- parent_id
- title
- slug
- excerpt
- content
- status
- sort_order
- is_task_enabled
- task_instruction

Jangan hardcode jumlah level sub-bab. Struktur harus bisa beranak terus selama masih masuk akal dari sisi UI.

### Content

Untuk MVP, konten boleh disimpan sebagai HTML dari WYSIWYG di field `content`.

Namun, pastikan:

- Input divalidasi.
- Output HTML tidak dirender sembarangan tanpa sanitasi.
- Styling typography disiapkan agar konten mudah dibaca.

Jika task meminta content block yang lebih fleksibel, gunakan tabel `lesson_blocks` dengan field:

- lesson_id
- type
- payload JSON
- sort_order

Tipe block yang mungkin:

- rich_text
- youtube
- image
- link
- button_link
- book_card
- file
- quote

### Comments

Komentar dikaitkan dengan lesson.

Aturan:

- User harus login.
- Body wajib divalidasi.
- Admin bisa hide/delete.
- Gunakan status: pending, visible, hidden.

### Submissions

Submission dikaitkan dengan lesson dan user.

Aturan:

- Hanya aktif jika `is_task_enabled = true`.
- Bisa berisi body, file, external link, atau kombinasi.
- File harus divalidasi.
- Admin bisa memberi feedback/status/score.

---

## Laravel Architecture Rules

Ikuti aturan berikut ketika menulis kode Laravel:

1. Controller harus tipis.
2. Validasi gunakan Form Request.
3. Logic yang mulai panjang pindahkan ke Service class.
4. Gunakan Eloquent relationship.
5. Gunakan route model binding.
6. Gunakan policy atau middleware untuk admin.
7. Gunakan migration yang jelas dan reversible.
8. Gunakan factory/seeder untuk data demo.
9. Gunakan pagination untuk list admin dan public.
10. Gunakan transaction untuk operasi kompleks.

Contoh struktur yang disarankan:

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Public/
│   │   └── Admin/
│   ├── Requests/
│   │   ├── Course/
│   │   ├── Lesson/
│   │   ├── Comment/
│   │   └── Submission/
│   └── Middleware/
├── Models/
├── Services/
│   ├── CourseService.php
│   ├── LessonTreeService.php
│   ├── CommentService.php
│   └── SubmissionService.php
└── Policies/
```

---

## Blade and View Rules

Gunakan Blade component untuk elemen yang berulang.

Komponen yang disarankan:

```text
resources/views/components/
├── public/
│   ├── navbar.blade.php
│   ├── footer.blade.php
│   ├── course-card.blade.php
│   ├── hero.blade.php
│   └── section-heading.blade.php
├── admin/
│   ├── sidebar.blade.php
│   ├── topbar.blade.php
│   ├── stat-card.blade.php
│   ├── data-table.blade.php
│   └── empty-state.blade.php
├── form/
│   ├── input.blade.php
│   ├── textarea.blade.php
│   ├── select.blade.php
│   ├── image-upload.blade.php
│   └── error.blade.php
└── learning/
    ├── lesson-sidebar.blade.php
    ├── lesson-tree-item.blade.php
    ├── content-renderer.blade.php
    ├── comment-section.blade.php
    └── submission-form.blade.php
```

Blade rule:

- Jangan duplikasi markup panjang.
- Jangan masukkan query database langsung di Blade.
- Jangan letakkan business logic di Blade.
- Gunakan partial/component untuk tree item recursive.
- Gunakan named route, bukan hardcoded URL.
- Gunakan escaping default `{{ }}` untuk text.
- Hanya gunakan `{!! !!}` jika HTML sudah disanitasi.

---

## TailwindCSS Rules

UI harus modern, clean, dan konsisten.

Gunakan prinsip:

- Mobile-first.
- Spacing konsisten.
- Typography readable.
- Card memiliki border/shadow halus.
- Gunakan warna ungu sebagai primary.
- Jangan terlalu banyak warna.
- Jangan membuat class Tailwind yang sulit dibaca jika bisa dipisah ke component.

Arah visual:

```text
Primary color: violet / purple
Background: white, slate-50, violet-50
Text: slate-900, slate-700, slate-500
Border: slate-200
Radius: rounded-2xl for cards, rounded-xl for smaller elements
Shadow: soft shadow only where needed
```

Contoh button primary:

```html
<a class="inline-flex items-center justify-center rounded-xl bg-violet-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2">
    Mulai Belajar
</a>
```

---

## Public Page Guidelines

### Landing Page

Landing page harus memiliki struktur:

1. Navbar
2. Hero
3. Course highlight
4. Profil pengajar / pemilik website
5. Benefit section
6. CTA
7. Footer

Jangan langsung menampilkan tabel atau layout admin di public page.

### Course Listing

Tampilkan course dalam card grid.

Card minimal berisi:

- Thumbnail
- Kategori / level badge
- Judul
- Excerpt
- CTA buka course

### Course Detail

Tampilkan:

- Cover / hero course
- Deskripsi course
- Daftar bab
- CTA mulai belajar

### Lesson Reader

Layout desktop:

- Sidebar kiri: lesson tree
- Main content kanan: isi materi
- Section bawah: komentar dan tugas

Layout mobile:

- Sidebar berubah menjadi accordion/drawer
- Konten tetap nyaman dibaca

---

## Admin CMS Guidelines

Admin CMS harus sederhana dan produktif.

Halaman admin list harus memiliki:

- Title
- Deskripsi singkat
- Button create
- Search/filter jika perlu
- Table
- Status badge
- Action edit/delete
- Pagination
- Empty state

Halaman form harus memiliki:

- Label jelas
- Helper text bila perlu
- Error validation
- Preview image jika upload
- Tombol save/cancel
- Section terpisah untuk setting lanjutan

Jangan membuat dashboard terlalu kompleks di awal.

---

## Database and Eloquent Rules

Relationship yang disarankan:

```php
// Course
public function lessons()
{
    return $this->hasMany(Lesson::class)->orderBy('sort_order');
}

// Lesson
public function course()
{
    return $this->belongsTo(Course::class);
}

public function parent()
{
    return $this->belongsTo(Lesson::class, 'parent_id');
}

public function children()
{
    return $this->hasMany(Lesson::class, 'parent_id')->orderBy('sort_order');
}

public function comments()
{
    return $this->hasMany(Comment::class);
}

public function submissions()
{
    return $this->hasMany(Submission::class);
}
```

Untuk lesson tree, eager load children agar tidak terjadi N+1 query.

---

## Security Rules

Selalu perhatikan:

- CSRF bawaan Laravel.
- Authorization admin.
- Validasi file upload.
- Sanitasi WYSIWYG HTML.
- Jangan simpan file langsung tanpa validasi.
- Jangan expose file private secara publik.
- Jangan percaya input `status`, `role`, atau `user_id` dari request tanpa kontrol.
- Gunakan `$fillable` secara eksplisit.
- Jangan gunakan `{!! $content !!}` kecuali konten sudah aman.

Jika sanitizer belum tersedia, tambahkan catatan TODO dan buat wrapper service agar mudah diganti.

---

## WYSIWYG Content Rules

Jika memakai WYSIWYG:

- Simpan HTML ke database.
- Validasi ukuran konten.
- Sanitasi sebelum render.
- Gunakan typography styling.

Contoh wrapper tampilan:

```html
<article class="prose prose-slate max-w-none prose-headings:scroll-mt-24 prose-a:text-violet-700 prose-a:no-underline hover:prose-a:underline">
    {!! $lesson->safe_content !!}
</article>
```

Jika belum ada `safe_content`, jangan langsung render raw HTML tanpa keputusan eksplisit.

---

## YouTube Embed Rules

Jangan simpan full iframe sembarangan dari user.

Lebih aman:

- Simpan URL YouTube.
- Parse video ID.
- Render iframe dari template controlled.

Contoh embed:

```html
<div class="aspect-video overflow-hidden rounded-2xl border border-slate-200 bg-slate-100">
    <iframe
        src="https://www.youtube.com/embed/{{ $videoId }}"
        class="h-full w-full"
        allowfullscreen
        loading="lazy">
    </iframe>
</div>
```

---

## Book Card Rules

Book card dapat digunakan untuk mengarahkan peserta ke buku atau resource tertentu.

Card minimal berisi:

- Cover
- Judul
- Author opsional
- Deskripsi singkat
- Link tujuan

Pastikan link eksternal menggunakan atribut aman:

```html
target="_blank" rel="noopener noreferrer"
```

---

## Testing Rules

Saat menambah fitur, pertimbangkan test berikut:

- Public course page dapat dibuka.
- Draft course tidak muncul di public.
- Admin dapat membuat course.
- Non-admin tidak bisa akses admin.
- Lesson tree tampil sesuai course.
- User login dapat komentar.
- User tidak login tidak dapat komentar.
- Submission hanya bisa dibuat jika task aktif.
- File upload tervalidasi.

Jalankan:

```bash
php artisan test
npm run build
```

Jika ada test gagal yang tidak terkait task, jelaskan dengan jujur.

---

## Implementation Workflow for Agent

Saat mengerjakan task:

1. Baca `context.md`.
2. Identifikasi area: public, admin, model, migration, atau UI.
3. Cek route yang sudah ada.
4. Cek model dan migration terkait.
5. Buat perubahan sekecil mungkin tapi lengkap.
6. Jaga konsistensi naming.
7. Tambahkan validasi.
8. Tambahkan authorization jika menyentuh admin/user data.
9. Tambahkan atau update test jika relevan.
10. Jalankan test/build jika memungkinkan.
11. Berikan ringkasan perubahan.

---

## Do

- Gunakan Laravel conventions.
- Gunakan Blade component reusable.
- Gunakan TailwindCSS secara konsisten.
- Pisahkan public dan admin controller.
- Buat UI yang enak dilihat.
- Gunakan service class jika logic mulai panjang.
- Gunakan named routes.
- Gunakan Form Request.
- Gunakan eager loading untuk tree.
- Beri empty state dan validation error.
- Pertahankan kesederhanaan.

---

## Don't

- Jangan ubah project menjadi SPA kecuali diminta.
- Jangan menambahkan React/Vue/Inertia jika project ini Blade-based.
- Jangan menambahkan package besar tanpa kebutuhan jelas.
- Jangan membuat semua logic di controller.
- Jangan query database langsung di Blade.
- Jangan render raw HTML tanpa sanitasi.
- Jangan hardcode URL.
- Jangan membuat UI admin terlalu ramai.
- Jangan mengabaikan mobile layout.
- Jangan mengabaikan authorization.
- Jangan menghapus fitur lama tanpa alasan.

---

## Preferred Output Style for Coding Agent

Saat memberi hasil kerja, gunakan format:

```text
Summary:
- ...

Changed files:
- ...

Validation:
- ...

Notes:
- ...
```

Jika ada keterbatasan:

```text
Notes:
- Saya belum menjalankan test karena ...
- Fitur sanitizer masih menggunakan wrapper awal dan bisa diganti dengan package sanitizer jika diperlukan.
```

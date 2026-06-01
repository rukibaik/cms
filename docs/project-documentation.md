# Dokumentasi Project CMS

Dokumen ini menjelaskan struktur project, folder penting, file utama di dalamnya, dan cara menjaga Web Core Vitals agar halaman tetap cepat, terutama di mobile.

Project ini menggunakan Laravel, Livewire, Blade, Tailwind CSS, Vite, dan CMS sederhana untuk mengatur konten halaman publik.

## Ringkasan Project

Project ini punya dua area utama:

| Area | Fungsi |
| --- | --- |
| Halaman publik | Landing page, detail service, section hero, about, services, pricing, CTA, contact |
| CMS admin | Form untuk mengubah konten hero, about, services, pricing, contact |

Alur sederhananya:

1. User membuka halaman publik.
2. Route di `routes/web.php` memanggil controller atau closure.
3. Controller mengambil data dari model.
4. Blade view di `resources/views` merender HTML.
5. CSS dari `resources/css/app.css` dibuild oleh Vite.
6. Gambar upload disimpan lewat helper `app/Support/OptimizedImage.php`.

## Folder Root

| File / Folder | Fungsi |
| --- | --- |
| `app/` | Logic utama aplikasi: controller, model, Livewire, middleware, helper |
| `resources/` | View Blade, CSS, dan JavaScript frontend |
| `routes/` | Definisi URL aplikasi |
| `database/` | Migration, seeder, factory |
| `config/` | Konfigurasi Laravel |
| `public/` | Entry point publik dan asset yang bisa diakses browser |
| `storage/` | File upload, cache, log, compiled view |
| `tests/` | Test feature dan unit |
| `docs/` | Dokumentasi project |
| `package.json` | Script dan dependency frontend |
| `composer.json` | Dependency PHP dan script Laravel |
| `vite.config.js` | Konfigurasi build asset Vite |

## Folder `app/`

Folder `app/` berisi logic utama aplikasi.

### `app/Http/Controllers`

| File | Fungsi |
| --- | --- |
| `Controller.php` | Base controller Laravel |
| `Frontend/HomeController.php` | Mengambil data halaman home: hero, about, service, pricing |
| `HeroSectionController.php` | Controller API/sederhana untuk update hero section |
| `PricingController.php` | Controller untuk data pricing |
| `ServiceController.php` | Controller untuk data service |

Catatan performa:

- `HomeController.php` harus mengambil data secukupnya saja.
- Gunakan `select()` untuk kolom yang dipakai.
- Gunakan `with()` atau `withCount()` agar tidak terjadi N+1 query.

### `app/Http/Middleware`

| File | Fungsi |
| --- | --- |
| `AdminMiddleware.php` | Membatasi halaman CMS agar hanya admin yang bisa akses |

### `app/Livewire`

Folder ini berisi komponen Livewire untuk halaman admin dan settings.

| File / Folder | Fungsi |
| --- | --- |
| `Dashboard.php` | Komponen dashboard admin |
| `Actions/Logout.php` | Action logout |
| `CMS/Hero/Edit.php` | Form CMS untuk update hero section |
| `CMS/About/Edit.php` | Form CMS untuk update about section |
| `CMS/Service/Index.php` | List service di CMS |
| `CMS/Service/Form.php` | Form create/edit service dan service item |
| `CMS/Service/ServiceSectionSettings.php` | Pengaturan judul dan tombol section service |
| `CMS/Pricing/Manage.php` | Form/list pricing dan benefit |
| `CMS/Contact/Edit.php` | Form CMS untuk update contact section |
| `Settings/*` | Komponen pengaturan user |

Catatan performa:

- Untuk upload gambar, gunakan `OptimizedImage`.
- Untuk tombol submit, gunakan loading state agar user tidak klik berkali-kali.
- Hindari logic berat di render Livewire.

### `app/Models`

Model adalah representasi tabel database.

| File | Fungsi |
| --- | --- |
| `User.php` | Model user login |
| `HeroSection.php` | Data section hero |
| `AboutSection.php` | Data section about |
| `Service.php` | Data service utama |
| `ServiceItem.php` | Item/detail di dalam service |
| `ServiceSectionSetting.php` | Pengaturan section service |
| `Pricing.php` | Data paket harga |
| `PricingBenefit.php` | Benefit pada paket harga |
| `ContactSection.php` | Data section contact |

Relasi penting:

| Model | Relasi |
| --- | --- |
| `Service` | Punya banyak `ServiceItem` |
| `ServiceItem` | Milik satu `Service` |
| `Pricing` | Punya banyak `PricingBenefit` |
| `PricingBenefit` | Milik satu `Pricing` |

### `app/Support`

| File | Fungsi |
| --- | --- |
| `OptimizedImage.php` | Resize, convert WebP, buat varian gambar kecil, buat `srcset`, hapus gambar dan variannya |

File ini penting untuk Web Core Vitals karena gambar biasanya menjadi penyebab utama halaman mobile lambat.

Yang dilakukan:

- Hero image dibatasi sampai 1920 x 1080.
- Service item image dibatasi sampai 1200 x 800.
- Upload dikonversi ke WebP.
- Varian kecil dibuat untuk mobile.
- View bisa memakai `srcset` agar browser memilih ukuran gambar yang paling cocok.

### `app/Providers`

| File | Fungsi |
| --- | --- |
| `AppServiceProvider.php` | Service provider utama aplikasi |
| `FortifyServiceProvider.php` | Konfigurasi auth Fortify |

### `app/Actions` dan `app/Concerns`

| File / Folder | Fungsi |
| --- | --- |
| `Actions/Fortify/CreateNewUser.php` | Logic registrasi user |
| `Actions/Fortify/ResetUserPassword.php` | Logic reset password |
| `Concerns/PasswordValidationRules.php` | Rule validasi password |
| `Concerns/ProfileValidationRules.php` | Rule validasi profile |

## Folder `resources/`

Folder ini berisi bagian frontend.

### `resources/css`

| File | Fungsi |
| --- | --- |
| `app.css` | Entry CSS utama Tailwind dan custom theme |

Isi penting:

- Import Tailwind.
- Import Flux CSS.
- Theme warna dan font.
- Utility `content-visibility-auto`.
- Pengaturan reduced motion.

Catatan Web Core Vitals:

- CSS harus tetap secukupnya.
- Gunakan class Tailwind yang benar-benar dipakai.
- `content-visibility: auto` membantu browser menunda render section bawah layar.

### `resources/js`

| File | Fungsi |
| --- | --- |
| `app.js` | Entry JavaScript frontend |

Saat ini file ini kosong. Ini bagus untuk INP karena halaman publik tidak menjalankan JavaScript custom yang tidak perlu.

### `resources/views/layouts`

| File / Folder | Fungsi |
| --- | --- |
| `guest.blade.php` | Layout halaman publik |
| `app.blade.php` | Layout area aplikasi/admin |
| `auth.blade.php` | Layout auth |
| `auth/card.blade.php` | Layout auth bentuk card |
| `auth/simple.blade.php` | Layout auth sederhana |
| `auth/split.blade.php` | Layout auth split |
| `app/header.blade.php` | Header layout admin |
| `app/sidebar.blade.php` | Sidebar layout admin |

File paling penting untuk halaman publik adalah `guest.blade.php`.

Hal yang dijaga di `guest.blade.php`:

- Meta viewport ada.
- Font memakai `display=swap`.
- Preload hero image bisa dimasukkan lewat `@stack('head')`.
- Public page hanya load CSS jika JavaScript tidak dipakai.

### `resources/views/pages`

| File | Fungsi |
| --- | --- |
| `home.blade.php` | Menyusun section halaman utama |
| `service-detail.blade.php` | Halaman detail service |

Catatan:

- `home.blade.php` hanya include section.
- Preload hero image diletakkan di `home.blade.php` karena URL gambar hero diketahui dari data CMS.
- `service-detail.blade.php` memakai lazy loading untuk gambar detail.

### `resources/views/sections`

| File | Fungsi |
| --- | --- |
| `hero.blade.php` | Section pertama halaman home dan kandidat LCP utama |
| `about.blade.php` | Section tentang perusahaan |
| `services.blade.php` | List service |
| `benefits.blade.php` | Benefit / value proposition |
| `pricing.blade.php` | Paket harga |
| `CTA.blade.php` | Call to action |
| `contact.blade.php` | Section contact dan form WhatsApp |

Catatan Web Core Vitals:

- `hero.blade.php` harus cepat muncul karena biasanya menjadi LCP.
- Section di bawah hero boleh memakai `content-visibility-auto`.
- Gambar bawah layar harus `loading="lazy"`.

### `resources/views/partials`

| File | Fungsi |
| --- | --- |
| `navbar.blade.php` | Navigasi utama |
| `footer.blade.php` | Footer |
| `head.blade.php` | Partial head bawaan/starter |
| `settings-heading.blade.php` | Heading halaman settings |

Catatan:

- Mobile menu di navbar memakai CSS-only toggle. Ini baik untuk INP karena tidak perlu JavaScript.

### `resources/views/livewire`

Folder ini berisi Blade untuk komponen Livewire.

| Folder / File | Fungsi |
| --- | --- |
| `auth/*` | View login, register, reset password, verification |
| `cms/about/edit.blade.php` | UI CMS about |
| `cms/hero/edit.blade.php` | UI CMS hero |
| `cms/pricing/manage.blade.php` | UI CMS pricing |
| `cms/service/index.blade.php` | UI list service |
| `cms/service/form.blade.php` | UI form service |
| `cms/service-section-settings.blade.php` | UI setting section service |
| `settings/*` | UI settings user |
| `dashboard.blade.php` | UI dashboard |

### `resources/views/components`

| File / Folder | Fungsi |
| --- | --- |
| `app-logo.blade.php` | Logo aplikasi |
| `app-logo-icon.blade.php` | Icon logo |
| `auth-header.blade.php` | Header auth |
| `auth-session-status.blade.php` | Status session auth |
| `desktop-user-menu.blade.php` | Menu user desktop |
| `placeholder-pattern.blade.php` | Placeholder visual |
| `settings/layout.blade.php` | Layout settings |

### `resources/views/flux`

| File / Folder | Fungsi |
| --- | --- |
| `icon/*` | Icon custom untuk Flux/navigation |
| `navlist/group.blade.php` | Group nav list |

## Folder `routes/`

| File | Fungsi |
| --- | --- |
| `web.php` | Route halaman publik dan CMS |
| `settings.php` | Route halaman settings |
| `console.php` | Route command console |

Route penting:

| Route | Fungsi |
| --- | --- |
| `/` | Halaman home |
| `/services/{slug}` | Detail service |
| `/dashboard` | Dashboard admin |
| `/cms/hero` | Edit hero |
| `/cms/about` | Edit about |
| `/cms/services` | Kelola service |
| `/cms/pricing` | Kelola pricing |
| `/cms/contact` | Kelola contact |

Catatan:

- Route CMS dilindungi middleware `auth` dan `admin`.
- Halaman publik harus sesederhana mungkin agar TTFB dan LCP cepat.

## Folder `database/`

### `database/migrations`

| File | Fungsi |
| --- | --- |
| `0001_01_01_000000_create_users_table.php` | Tabel user |
| `0001_01_01_000001_create_cache_table.php` | Tabel cache |
| `0001_01_01_000002_create_jobs_table.php` | Tabel queue jobs |
| `2025_08_14_170933_add_two_factor_columns_to_users_table.php` | Kolom two factor auth |
| `2026_04_23_135005_create_hero_sections_table.php` | Tabel hero section |
| `2026_04_23_135016_create_about_sections_table.php` | Tabel about section |
| `2026_04_23_135025_create_services_table.php` | Tabel service |
| `2026_04_23_135039_create_service_items_table.php` | Tabel item service |
| `2026_04_23_135106_create_service_section_settings_table.php` | Tabel setting service section |
| `2026_04_23_135134_create_pricings_table.php` | Tabel pricing |
| `2026_04_23_135148_create_pricing_benefits_table.php` | Tabel benefit pricing |
| `2026_05_28_153222_create_contact_sections_table.php` | Tabel contact section |

### File lain

| File | Fungsi |
| --- | --- |
| `seeders/DatabaseSeeder.php` | Seeder utama |
| `factories/UserFactory.php` | Factory untuk test/user dummy |

## Folder `config/`

| File | Fungsi |
| --- | --- |
| `app.php` | Konfigurasi aplikasi |
| `auth.php` | Konfigurasi authentication |
| `cache.php` | Konfigurasi cache |
| `database.php` | Koneksi database |
| `filesystems.php` | Disk file, termasuk public storage |
| `fortify.php` | Konfigurasi Fortify auth |
| `logging.php` | Konfigurasi log |
| `mail.php` | Konfigurasi mail |
| `queue.php` | Konfigurasi queue |
| `services.php` | Konfigurasi service pihak ketiga |
| `session.php` | Konfigurasi session |

## Folder `public/`

| File | Fungsi |
| --- | --- |
| `index.php` | Entry point Laravel dari browser |
| `favicon.ico` | Favicon fallback |
| `favicon.svg` | Favicon SVG |
| `apple-touch-icon.png` | Icon untuk Apple device |
| `robots.txt` | Instruksi crawler/search engine |
| `build/` | Hasil build Vite, dibuat oleh `npm run build` |

Catatan:

- Jangan edit file di `public/build` secara manual.
- File hasil upload public biasanya diakses lewat symlink `public/storage`.

## Folder `storage/`

| Folder | Fungsi |
| --- | --- |
| `app/public` | File upload yang bisa diakses publik |
| `framework/cache` | Cache framework |
| `framework/views` | Compiled Blade view |
| `framework/sessions` | Session file jika driver file |
| `logs` | Log aplikasi |

Catatan:

- Upload gambar hero dan service disimpan di disk public.
- Untuk production, pastikan `php artisan storage:link` sudah dijalankan.

## Folder `tests/`

| Folder / File | Fungsi |
| --- | --- |
| `Feature/*` | Test alur fitur aplikasi |
| `Feature/Auth/*` | Test auth |
| `Feature/Settings/*` | Test settings |
| `Feature/DashboardTest.php` | Test dashboard |
| `Unit/ExampleTest.php` | Contoh unit test |
| `Pest.php` | Konfigurasi Pest |
| `TestCase.php` | Base test case |

Cara menjalankan:

```bash
php artisan test
```

## Folder `docs/`

| File | Fungsi |
| --- | --- |
| `erd.md` | Dokumentasi struktur database/ERD |
| `web-core-vitals.md` | Dokumentasi khusus Core Web Vitals |
| `project-documentation.md` | Dokumentasi project ini |

## File Build dan Dependency

| File | Fungsi |
| --- | --- |
| `composer.json` | Dependency PHP dan script Laravel |
| `composer.lock` | Versi dependency PHP yang terkunci |
| `package.json` | Dependency frontend dan script Vite |
| `bun.lock` | Lockfile Bun |
| `vite.config.js` | Konfigurasi Vite dan Tailwind |
| `phpunit.xml` | Konfigurasi test |
| `pint.json` | Konfigurasi formatter Laravel Pint |

Script penting:

```bash
npm run build
php artisan test
composer lint
```

Di Windows PowerShell, jika `npm run build` diblokir execution policy, pakai:

```bash
npm.cmd run build
```

## Cara Achieve Web Core Vitals

Web Core Vitals adalah ukuran pengalaman user saat membuka website. Fokus utamanya:

| Metric | Arti simple | Target bagus |
| --- | --- | --- |
| LCP | Konten utama paling besar cepat muncul | <= 2.5 detik |
| INP | Halaman cepat merespons klik/input | <= 200 ms |
| CLS | Layout tidak loncat-loncat | <= 0.1 |

### 1. LCP: Bikin konten utama cepat muncul

Biasanya LCP di project ini adalah hero image atau hero title.

Yang sudah dilakukan:

- Hero image diberi `loading="eager"`.
- Hero image diberi `fetchpriority="high"`.
- Hero image diberi `width` dan `height`.
- Hero image dipreload dari `home.blade.php`.
- Upload hero dikompres menjadi WebP.
- Gambar punya `srcset`, jadi mobile bisa ambil gambar lebih kecil.

Cara menjaga:

1. Jangan pasang banyak gambar besar di layar pertama.
2. Hanya hero image yang boleh diprioritaskan.
3. Jangan beri `fetchpriority="high"` ke semua gambar.
4. Jangan membuat hero menunggu JavaScript.
5. Pastikan gambar upload lewat `OptimizedImage`.

Contoh bagus:

```blade
<img
    src="{{ asset('storage/' . $hero->background_image) }}"
    srcset="{{ \App\Support\OptimizedImage::srcset($hero->background_image) }}"
    sizes="100vw"
    width="1920"
    height="1080"
    loading="eager"
    fetchpriority="high"
    decoding="async"
    alt=""
>
```

### 2. INP: Bikin interaksi terasa ringan

INP buruk biasanya terjadi karena JavaScript terlalu berat atau klik menjalankan pekerjaan besar.

Yang sudah bagus di project ini:

- `resources/js/app.js` kosong untuk halaman publik.
- Mobile menu memakai CSS-only toggle.
- Form admin memakai Livewire, bukan JavaScript custom besar.

Cara menjaga:

1. Jangan menambah JavaScript kalau bisa diselesaikan dengan HTML/CSS.
2. Jangan pasang event listener global yang berat.
3. Tombol submit di CMS harus punya loading/disabled state.
4. Animasi hover jangan mengubah layout besar.
5. Hindari script pihak ketiga yang tidak penting.

Contoh aman:

```blade
<button wire:click="save" wire:loading.attr="disabled">
    <span wire:loading.remove>Save</span>
    <span wire:loading>Saving...</span>
</button>
```

### 3. CLS: Bikin layout stabil

CLS buruk terjadi saat konten bergeser setelah halaman terlihat.

Yang sudah dilakukan:

- Gambar hero punya `width` dan `height`.
- Gambar service detail punya `width` dan `height`.
- Font memakai `display=swap`.
- Hero section punya tinggi stabil.
- Lazy image tetap diberi ukuran.

Cara menjaga:

1. Semua gambar harus punya `width` dan `height`.
2. Jangan inject konten besar di atas konten yang sudah terlihat.
3. Jangan membuat banner muncul tiba-tiba di atas halaman.
4. Jangan memakai font tanpa fallback.
5. Jika ada card/list, siapkan ruang yang stabil.

Contoh gambar bawah layar:

```blade
<img
    src="{{ asset('storage/' . $item->image) }}"
    width="1200"
    height="800"
    loading="lazy"
    decoding="async"
    alt="{{ $item->title }}"
>
```

## Checklist Saat Menambah Fitur Baru

Gunakan checklist ini sebelum merge.

### Untuk gambar

- Upload lewat `OptimizedImage`.
- Format output WebP.
- Ada `width` dan `height`.
- Gambar atas layar pakai `loading="eager"`.
- Gambar bawah layar pakai `loading="lazy"`.
- Gunakan `srcset` jika gambar tampil besar di mobile dan desktop.

### Untuk Blade section

- Section pertama harus ringan.
- Section bawah boleh pakai `content-visibility-auto`.
- Jangan load data yang tidak dipakai.
- Hindari markup terlalu besar di atas layar pertama.

### Untuk query database

- Pakai `select()` untuk kolom yang dibutuhkan.
- Pakai `with()` untuk relasi yang ditampilkan.
- Pakai `withCount()` jika hanya perlu jumlah relasi.
- Hindari query di dalam loop Blade.

### Untuk CSS

- Gunakan utility Tailwind yang sudah ada.
- Hindari animasi `width`, `height`, `top`, `left` untuk elemen besar.
- Untuk animasi, pakai `opacity` dan `transform`.
- Pastikan mobile layout tidak overflow.

### Untuk JavaScript

- Jangan load JS di halaman publik jika tidak dipakai.
- Jika butuh JS, buat kecil dan spesifik.
- Jangan menjalankan pekerjaan berat saat klik/input.

## Cara Mengukur

Untuk cek cepat:

1. Build asset production.

```bash
npm.cmd run build
```

2. Jalankan aplikasi.

```bash
php artisan serve
```

3. Buka Chrome DevTools.
4. Jalankan Lighthouse dengan mode mobile.
5. Cek bagian Performance.
6. Lihat elemen LCP, jumlah JavaScript, dan CLS diagnostics.

Untuk data production:

- Gunakan PageSpeed Insights.
- Gunakan Google Search Console Core Web Vitals.
- Jika traffic sudah cukup, lihat data mobile dan desktop secara terpisah.

## Aturan Simple Agar Tetap Cepat

1. Hero harus cepat, jangan berat.
2. Mobile jangan dipaksa download gambar desktop.
3. Gambar harus punya ukuran tetap.
4. JavaScript publik harus sangat sedikit.
5. Query database jangan mengambil data yang tidak ditampilkan.
6. Section bawah layar tidak perlu dirender terlalu awal.
7. Test build sebelum deploy.

## Perintah Penting

```bash
composer install
npm install
php artisan migrate
php artisan storage:link
npm.cmd run build
php artisan test
```

## Referensi Dokumen Lain

- `docs/erd.md`
- `docs/web-core-vitals.md`

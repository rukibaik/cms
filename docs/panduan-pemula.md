# Panduan Pemula Project CMS

Dokumen ini dibuat untuk orang yang baru pertama kali membuka project ini.
Bahasanya dibuat sederhana dan langsung ke tempat yang perlu dibuka.

Project ini adalah website landing page dengan CMS admin.
Fokus utama project ini adalah halaman publik yang cepat dan stabil agar Core Web Vitals tetap bagus.

## Isi Dokumen

1. Apa isi project ini
2. Cara menjalankan project
3. Cara membuka CMS
4. Cara mengubah tampilan landing page
5. Cara kerja project
6. Cara menjaga Core Web Vitals
7. File penting yang sering diedit
8. Checklist sebelum upload atau deploy

## 1. Apa Isi Project Ini

Project ini memakai:

| Bagian | Teknologi |
| --- | --- |
| Backend | Laravel |
| Admin interaktif | Livewire |
| Template HTML | Blade |
| Styling | Tailwind CSS |
| Build asset | Vite |
| Database default | SQLite |

Ada dua area utama:

| Area | URL | Fungsi |
| --- | --- | --- |
| Landing page | `/` | Halaman website untuk pengunjung |
| CMS admin | `/dashboard` dan `/cms/...` | Mengubah isi website |

Halaman landing page disusun dari beberapa section:

| Section | File |
| --- | --- |
| Hero | `resources/views/sections/hero.blade.php` |
| About | `resources/views/sections/about.blade.php` |
| Services | `resources/views/sections/services.blade.php` |
| Benefits | `resources/views/sections/benefits.blade.php` |
| Pricing | `resources/views/sections/pricing.blade.php` |
| CTA | `resources/views/sections/CTA.blade.php` |
| Contact | `resources/views/sections/contact.blade.php` |

File yang menyusun semua section menjadi satu halaman adalah:

```text
resources/views/pages/home.blade.php
```

## 2. Cara Menjalankan Project

### 2.1 Kebutuhan di komputer

Pastikan komputer punya:

| Kebutuhan | Versi yang aman |
| --- | --- |
| PHP | 8.3 atau lebih baru |
| Composer | Versi 2 |
| Node.js | Versi modern |
| NPM | Ikut dari Node.js |

Di Windows PowerShell, pakai `npm.cmd`, bukan `npm`, jika muncul error execution policy.

### 2.2 Masuk ke folder project

```powershell
cd C:\Users\XonTHol\Documents\cms
```

### 2.3 Install dependency PHP

```powershell
composer install
```

Perintah ini membuat folder `vendor`.
Folder `vendor` berisi package PHP yang dibutuhkan Laravel.

### 2.4 Install dependency frontend

Untuk Windows PowerShell:

```powershell
npm.cmd install
```

Untuk macOS atau Linux:

```bash
npm install
```

Perintah ini membuat folder `node_modules`.
Folder `node_modules` berisi package untuk Tailwind dan Vite.

### 2.5 Buat file `.env`

Jika file `.env` belum ada, jalankan:

```powershell
Copy-Item .env.example .env
```

Di macOS atau Linux:

```bash
cp .env.example .env
```

File `.env` adalah file setting lokal.
Contohnya berisi nama aplikasi, koneksi database, dan mode debug.

### 2.6 Buat app key

```powershell
php artisan key:generate
```

Laravel membutuhkan `APP_KEY` untuk keamanan.
Jika belum ada, login dan session bisa bermasalah.

### 2.7 Pastikan database SQLite ada

Project ini memakai SQLite dari `.env.example`.
File database yang dipakai adalah:

```text
database/database.sqlite
```

Jika file itu belum ada, buat dengan:

```powershell
New-Item -ItemType File database\database.sqlite
```

Jika file sudah ada, perintah ini tidak perlu dijalankan.

### 2.8 Jalankan migration

```powershell
php artisan migrate
```

Migration membuat tabel database, misalnya:

| Tabel | Fungsi |
| --- | --- |
| `users` | Data user admin |
| `hero_sections` | Data hero landing page |
| `about_sections` | Data about |
| `services` | Data service |
| `service_items` | Detail service |
| `pricings` | Paket harga |
| `pricing_benefits` | Benefit harga |
| `contact_sections` | Data contact |

### 2.9 Buat storage link

```powershell
php artisan storage:link
```

Perintah ini membuat link:

```text
public/storage -> storage/app/public
```

Ini penting karena gambar upload dari CMS disimpan di `storage/app/public`,
tetapi browser membacanya lewat `public/storage`.

### 2.10 Jalankan server Laravel

Buka terminal pertama:

```powershell
php artisan serve
```

Biasanya website bisa dibuka di:

```text
http://127.0.0.1:8000
```

### 2.11 Jalankan Vite untuk CSS

Buka terminal kedua.

Untuk Windows PowerShell:

```powershell
npm.cmd run dev
```

Untuk macOS atau Linux:

```bash
npm run dev
```

Vite memproses Tailwind CSS.
Tetap buka website dari URL Laravel, yaitu `http://127.0.0.1:8000`.
Jangan membuka URL Vite sebagai website utama.

### 2.12 Queue worker

Script bawaan project punya queue worker.
Untuk development biasa, landing page tetap bisa jalan tanpa ini.
Jika nanti ada fitur job atau queue, buka terminal ketiga:

```powershell
php artisan queue:listen --tries=1
```

### 2.13 Build untuk production

Sebelum upload ke server, buat asset production.

Untuk Windows PowerShell:

```powershell
npm.cmd run build
```

Untuk macOS atau Linux:

```bash
npm run build
```

Hasil build masuk ke:

```text
public/build
```

Jangan edit file di `public/build` secara manual.
File itu hasil otomatis dari Vite.

## 3. Cara Membuka CMS

### 3.1 Buat akun admin

Project ini mengaktifkan halaman register.
Buka:

```text
http://127.0.0.1:8000/register
```

Buat akun baru.
Secara default, tabel `users` memberi user baru role `admin` dan status aktif.
Setelah register, user bisa masuk ke dashboard.

### 3.2 Login

Buka:

```text
http://127.0.0.1:8000/login
```

Setelah login, buka:

```text
http://127.0.0.1:8000/dashboard
```

### 3.3 Halaman CMS

| URL | Fungsi |
| --- | --- |
| `/cms/hero` | Mengubah hero: title, subtitle, tombol, background |
| `/cms/about` | Mengubah about |
| `/cms/services` | Mengubah daftar service |
| `/cms/services/create` | Membuat service baru |
| `/cms/pricing` | Mengubah paket harga |
| `/cms/contact` | Mengubah contact dan WhatsApp |

Route CMS dilindungi oleh:

```text
auth
admin
```

Artinya user harus login, punya role `admin`, dan status `is_active` harus aktif.

## 4. Cara Mengubah Tampilan Landing Page

Bagian ini hanya untuk landing page.
File styling landing page adalah:

```text
resources/css/guest.css
```

Jangan bingung dengan:

```text
resources/css/app.css
```

`app.css` lebih banyak dipakai untuk area aplikasi/admin.
Landing page publik memakai `guest.css`.

### 4.1 Mengubah logo di navbar

Logo navbar ada di:

```text
resources/views/partials/navbar.blade.php
```

Saat ini logo berbentuk huruf `P` dan teks:

```blade
Prestige <span class="text-brand-accent">In Media</span>
```

Bagian huruf `P` ada di dalam tag:

```blade
<span class="flex h-9 w-9 ...">
    P
</span>
```

Jika hanya ingin ganti huruf logo, ubah `P` menjadi huruf lain.

Jika ingin memakai gambar logo:

1. Buat folder:

```text
public/images
```

2. Simpan logo, misalnya:

```text
public/images/logo.png
```

3. Ganti bagian logo huruf `P` dengan:

```blade
<img
    src="/images/logo.png"
    alt="Nama Brand"
    width="36"
    height="36"
    class="h-9 w-9 rounded-md object-contain"
>
```

Penting untuk Core Web Vitals:

- Selalu isi `width` dan `height`.
- Jangan memakai logo terlalu besar.
- Format yang disarankan: SVG, WebP, atau PNG kecil.

### 4.2 Mengubah warna landing page

Warna utama landing page ada di:

```text
resources/css/guest.css
```

Cari bagian:

```css
@theme {
    --color-brand-dark: #0a0a0a;
    --color-brand-darker: #050505;
    --color-brand-accent: #0D45FF;
    --color-brand-accent-light: #e8c97a;
    --color-brand-accent-dark: #b8923e;
}
```

Arti warna:

| Variable | Dipakai untuk |
| --- | --- |
| `--color-brand-dark` | Background gelap utama |
| `--color-brand-darker` | Background paling gelap |
| `--color-brand-accent` | Warna utama brand, tombol, link penting |
| `--color-brand-accent-light` | Warna hover tombol |
| `--color-brand-accent-dark` | Variasi gelap accent |

Contoh mengganti warna brand utama menjadi merah:

```css
--color-brand-accent: #E11D48;
```

Setelah mengubah CSS:

```powershell
npm.cmd run dev
```

atau jika untuk production:

```powershell
npm.cmd run build
```

Penting:

- Ubah warna dari variable dulu.
- Jangan mengganti satu per satu class di banyak file jika tidak perlu.
- Dengan variable, semua bagian yang memakai `text-brand-accent`, `bg-brand-accent`, dan `border-brand-accent` ikut berubah.

### 4.3 Mengubah background hero

Cara paling mudah adalah lewat CMS.

Buka:

```text
/cms/hero
```

Ubah field:

```text
Background Image
```

Aturan upload:

| Aturan | Nilai |
| --- | --- |
| Format | JPG, JPEG, PNG, WebP |
| Maksimal file | 2 MB |
| Maksimal dimensi | 3000 x 3000 px |
| Hasil simpan | WebP |

Saat disimpan, gambar diproses oleh:

```text
app/Support/OptimizedImage.php
```

Untuk hero, gambar dibatasi maksimal:

```text
1920 x 1080
```

Project juga membuat beberapa ukuran kecil untuk `srcset`.
Ini membantu mobile tidak perlu download gambar desktop yang terlalu besar.

### 4.4 Mengubah warna background section

Background section diatur dari class Blade.

Contoh di hero:

```text
resources/views/sections/hero.blade.php
```

Ada class:

```blade
bg-brand-darker
```

Contoh di CTA:

```text
resources/views/sections/CTA.blade.php
```

Ada class:

```blade
bg-brand-accent
```

Jika ingin ganti warna semua section gelap, ubah variable di `guest.css`.
Jika ingin hanya satu section berubah, ubah class di file section tersebut.

Contoh:

```blade
<section class="... bg-brand-dark ...">
```

menjadi:

```blade
<section class="... bg-brand-darker ...">
```

### 4.5 Mengubah font landing page

Font landing page ada di:

```text
resources/css/guest.css
```

Cari:

```css
--font-sans: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
--font-serif: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
```

`--font-sans` dipakai untuk font umum.
`--font-serif` dipakai oleh class `font-serif`.

Contoh ganti font umum ke Arial:

```css
--font-sans: Arial, sans-serif;
```

Contoh ganti font judul serif:

```css
--font-serif: Georgia, serif;
```

Saran untuk Core Web Vitals:

- Pakai system font jika bisa.
- System font cepat karena tidak perlu download font dari internet.
- Jika memakai Google Fonts, pilih sedikit weight saja.
- Jangan memakai banyak keluarga font sekaligus.

### 4.6 Mengubah teks lewat CMS

Sebagian teks landing page bisa diubah dari CMS.

| Bagian | URL CMS | Field |
| --- | --- | --- |
| Hero title | `/cms/hero` | `Title` |
| Hero subtitle | `/cms/hero` | `Subtitle` |
| Tombol hero | `/cms/hero` | `Button Text`, `Button Link` |
| About | `/cms/about` | `Title`, `Subtitle`, `Description` |
| Service section | `/cms/services` | `Section Title`, `Section Subtitle`, `Button Text`, `Button Link` |
| Service card | `/cms/services/create` atau edit service | `Title`, `Slug`, `Subtitle`, `Description` |
| Service detail item | Edit service | `Item Title`, `Item Subtitle`, `Item Description`, `Image` |
| Pricing | `/cms/pricing` | `Name`, `Price`, `Button Text`, `Button Link`, `Description`, `Benefits` |
| Contact | `/cms/contact` | `Eyebrow`, `Title`, `Subtitle`, `WhatsApp Number`, `Email`, `Phone`, `Address`, `Button Text` |

Setelah klik save di CMS, data masuk database.
Halaman landing page akan membaca data terbaru dari database.

### 4.7 Mengubah teks yang masih hard-coded di file

Ada beberapa teks yang belum masuk CMS.
Untuk mengubahnya, edit file Blade.

| Teks | File |
| --- | --- |
| Brand di navbar | `resources/views/partials/navbar.blade.php` |
| Menu navbar | `resources/views/partials/navbar.blade.php` |
| Teks kecil hero `Prestige In Media` | `resources/views/sections/hero.blade.php` |
| List kecil hero: `Design`, `Visual Photo`, dan lainnya | `resources/views/sections/hero.blade.php` |
| Benefits section | `resources/views/sections/benefits.blade.php` |
| Judul pricing `Harga Yang Sederhana...` | `resources/views/sections/pricing.blade.php` |
| CTA section | `resources/views/sections/CTA.blade.php` |
| Label form contact seperti `Full Name` dan `Subject` | `resources/views/sections/contact.blade.php` |
| Footer | `resources/views/partials/footer.blade.php` |

Setelah mengubah file Blade, refresh browser.
Jika perubahan CSS tidak muncul, pastikan Vite sedang jalan.

## 5. Cara Kerja Project

### 5.1 Alur halaman landing page

Saat user membuka:

```text
/
```

Alurnya seperti ini:

1. Route dibaca dari `routes/web.php`.
2. Route `/` memanggil `HomeController@index`.
3. Controller mengambil data dari database.
4. Data dikirim ke `resources/views/pages/home.blade.php`.
5. `home.blade.php` memanggil semua section.
6. Layout utama memakai `resources/views/layouts/guest.blade.php`.
7. CSS landing page dimuat dari `resources/css/guest.css`.
8. Browser menampilkan landing page.

Route utama:

```php
Route::get('/', [HomeController::class, 'index'])->name('home');
```

File controller:

```text
app/Http/Controllers/Frontend/HomeController.php
```

File view utama:

```text
resources/views/pages/home.blade.php
```

Layout publik:

```text
resources/views/layouts/guest.blade.php
```

### 5.2 Data yang diambil oleh home page

`HomeController` mengambil:

| Data | Model |
| --- | --- |
| Hero | `HeroSection` |
| About | `AboutSection` |
| Service setting | `ServiceSectionSetting` |
| Services | `Service` |
| Pricing | `Pricing` |

Controller memakai `select()` supaya hanya kolom yang dibutuhkan yang diambil.
Ini membantu halaman lebih ringan.

Untuk pricing, controller memakai:

```php
with(['benefits:id,pricing_id,benefit,sort_order'])
```

Ini mengambil benefit pricing sekaligus.
Tujuannya agar tidak terjadi query berulang di dalam loop Blade.

### 5.3 Alur CMS

Contoh saat admin mengubah hero:

1. Admin login.
2. Admin buka `/cms/hero`.
3. Route memanggil Livewire component `HeroEdit`.
4. File logic ada di `app/Livewire/CMS/Hero/Edit.php`.
5. File tampilan form ada di `resources/views/livewire/cms/hero/edit.blade.php`.
6. Saat klik `Save Changes`, method `save()` berjalan.
7. Data disimpan ke tabel `hero_sections`.
8. Landing page membaca data baru itu saat dibuka.

### 5.4 Alur gambar upload

Contoh upload background hero:

1. Admin pilih gambar di `/cms/hero`.
2. Livewire validasi gambar.
3. Gambar dikirim ke `app/Support/OptimizedImage.php`.
4. Gambar diubah menjadi WebP.
5. Gambar besar dibatasi maksimal `1920 x 1080`.
6. Varian kecil dibuat untuk responsive image.
7. File disimpan di `storage/app/public`.
8. Browser membaca gambar lewat `public/storage`.

Ini penting untuk Core Web Vitals karena gambar besar sering menjadi penyebab website lambat.

### 5.5 Alur detail service

Saat user membuka:

```text
/services/{slug}
```

Route di `routes/web.php` mencari service berdasarkan `slug`.
Lalu view yang dipakai adalah:

```text
resources/views/pages/service-detail.blade.php
```

Service detail menampilkan:

- Judul service
- Subtitle
- Description
- Service items
- Gambar item jika ada

## 6. Core Web Vitals di Project Ini

Core Web Vitals adalah ukuran kualitas pengalaman user saat membuka website.
Target project ini adalah landing page yang cepat, ringan, dan tidak loncat-loncat.

Ada tiga metric utama:

| Metric | Arti sederhana | Target bagus |
| --- | --- | --- |
| LCP | Konten utama cepat terlihat | Maksimal 2.5 detik |
| INP | Klik dan input cepat merespons | Maksimal 200 ms |
| CLS | Layout tidak bergeser tiba-tiba | Maksimal 0.1 |

### 6.1 LCP di project ini

LCP biasanya berasal dari hero section.
Bisa berupa:

- Background hero
- Judul besar hero

File penting:

```text
resources/views/sections/hero.blade.php
resources/views/pages/home.blade.php
app/Support/OptimizedImage.php
```

Yang sudah dilakukan:

| Teknik | Lokasi | Fungsi |
| --- | --- | --- |
| Hero image `loading="eager"` | `hero.blade.php` | Gambar hero segera dimuat |
| Hero image `fetchpriority="high"` | `hero.blade.php` | Browser memberi prioritas tinggi |
| `width` dan `height` | `hero.blade.php` | Browser tahu ukuran gambar sejak awal |
| Preload hero image | `home.blade.php` | Gambar hero diminta lebih awal |
| Convert WebP | `OptimizedImage.php` | Ukuran file lebih kecil |
| `srcset` | `OptimizedImage.php` dan `hero.blade.php` | Mobile bisa ambil gambar lebih kecil |

Aturan aman:

- Hanya gambar hero yang boleh `fetchpriority="high"`.
- Jangan menaruh banyak gambar besar di layar pertama.
- Jangan membuat hero menunggu JavaScript.
- Upload background hero lewat CMS agar dioptimasi otomatis.

### 6.2 INP di project ini

INP berhubungan dengan respons halaman saat user klik, mengetik, atau membuka menu.

File penting:

```text
resources/views/layouts/guest.blade.php
resources/views/partials/navbar.blade.php
resources/views/sections/contact.blade.php
resources/css/guest.css
```

Yang sudah dilakukan:

| Teknik | Lokasi | Fungsi |
| --- | --- | --- |
| Landing page hanya load `guest.css` | `guest.blade.php` | JavaScript publik tetap sangat kecil |
| Menu mobile CSS-only | `navbar.blade.php` dan `guest.css` | Buka menu tanpa JavaScript |
| Contact form pakai script kecil | `contact.blade.php` | Hanya untuk membuka WhatsApp |
| Transisi singkat | `guest.css` | Interaksi terasa ringan |

Aturan aman:

- Jangan menambah JavaScript besar di landing page.
- Jangan memasang slider berat jika tidak perlu.
- Jangan memasang banyak script pihak ketiga.
- Jika butuh interaksi sederhana, coba pakai HTML dan CSS dulu.

### 6.3 CLS di project ini

CLS terjadi kalau layout bergeser setelah halaman terlihat.

File penting:

```text
resources/views/sections/hero.blade.php
resources/views/pages/service-detail.blade.php
resources/css/guest.css
```

Yang sudah dilakukan:

| Teknik | Lokasi | Fungsi |
| --- | --- | --- |
| Gambar punya `width` dan `height` | Hero dan detail service | Browser menyiapkan ruang gambar |
| Hero memakai `min-h-[100svh]` | `hero.blade.php` | Tinggi hero stabil |
| `scrollbar-gutter: stable` | `guest.css` | Mengurangi geser saat scrollbar muncul |
| `content-visibility-auto` | Section bawah | Browser bisa menunda render section bawah |

Aturan aman:

- Setiap gambar harus punya `width` dan `height`.
- Jangan membuat banner muncul tiba-tiba di atas halaman.
- Jangan inject konten besar di atas hero setelah halaman terbuka.
- Jangan mengubah font terlalu banyak setelah halaman dimuat.

## 7. File Penting yang Sering Diedit

| Kebutuhan | File |
| --- | --- |
| Susunan landing page | `resources/views/pages/home.blade.php` |
| Layout publik | `resources/views/layouts/guest.blade.php` |
| CSS landing page | `resources/css/guest.css` |
| Navbar dan logo | `resources/views/partials/navbar.blade.php` |
| Footer | `resources/views/partials/footer.blade.php` |
| Hero | `resources/views/sections/hero.blade.php` |
| About | `resources/views/sections/about.blade.php` |
| Services | `resources/views/sections/services.blade.php` |
| Benefits | `resources/views/sections/benefits.blade.php` |
| Pricing | `resources/views/sections/pricing.blade.php` |
| CTA | `resources/views/sections/CTA.blade.php` |
| Contact | `resources/views/sections/contact.blade.php` |
| Route website | `routes/web.php` |
| Data home | `app/Http/Controllers/Frontend/HomeController.php` |
| Optimasi gambar | `app/Support/OptimizedImage.php` |
| Build asset | `vite.config.js` |

## 8. Yang Jangan Diedit Sembarangan

| File atau folder | Alasan |
| --- | --- |
| `vendor` | Hasil install Composer |
| `node_modules` | Hasil install NPM |
| `public/build` | Hasil build Vite |
| `storage/framework` | Cache internal Laravel |
| `composer.lock` | Mengunci versi package PHP |
| `bun.lock` | Mengunci versi package Bun |

Jika ingin mengubah tampilan, biasanya cukup edit:

```text
resources/css/guest.css
resources/views/partials/navbar.blade.php
resources/views/partials/footer.blade.php
resources/views/sections/*.blade.php
```

## 9. Cara Cek Setelah Mengubah Tampilan

### 9.1 Cek cepat di lokal

1. Jalankan server Laravel:

```powershell
php artisan serve
```

2. Jalankan Vite:

```powershell
npm.cmd run dev
```

3. Buka:

```text
http://127.0.0.1:8000
```

4. Cek desktop dan mobile.
5. Pastikan tidak ada teks keluar dari layar.
6. Pastikan gambar hero muncul.
7. Pastikan tombol dan link bisa diklik.

### 9.2 Cek build production

```powershell
npm.cmd run build
```

Jika build berhasil, asset production siap.

### 9.3 Cek test Laravel

```powershell
php artisan test
```

Jika test gagal, baca pesan error-nya dulu.
Jangan deploy sebelum tahu penyebabnya.

### 9.4 Cek Core Web Vitals

Untuk cek lokal:

1. Buka Chrome.
2. Buka website.
3. Tekan `F12`.
4. Buka tab Lighthouse.
5. Pilih mode Mobile.
6. Jalankan audit.
7. Lihat Performance, LCP, INP/TBT, dan CLS.

Untuk website yang sudah online:

- Gunakan PageSpeed Insights.
- Gunakan Google Search Console jika website sudah punya traffic.

## 10. Checklist Core Web Vitals

Gunakan checklist ini setiap selesai mengubah landing page.

### Logo

- Logo tidak terlalu besar.
- Jika logo gambar, ada `width` dan `height`.
- Logo tidak membuat navbar berubah tinggi saat loading.

### Warna

- Warna diubah dari `resources/css/guest.css`.
- Kontras teks tetap mudah dibaca.
- Tombol utama tetap terlihat jelas.

### Background

- Background hero diupload lewat CMS.
- Ukuran file tidak lebih dari 2 MB.
- Jangan pakai gambar terlalu gelap atau terlalu ramai sampai teks sulit dibaca.
- Jangan menaruh banyak gambar besar di atas layar pertama.

### Font

- Gunakan sedikit jenis font.
- Gunakan system font jika bisa.
- Jika memakai external font, jangan terlalu banyak weight.

### Teks

- Judul mobile tidak terlalu panjang.
- Tombol tidak berisi teks terlalu panjang.
- Teks tidak menabrak elemen lain.
- Teks penting tetap muncul tanpa menunggu JavaScript.

### Gambar

- Semua gambar punya `width` dan `height`.
- Gambar hero boleh `loading="eager"`.
- Gambar bawah layar gunakan `loading="lazy"` jika ditambahkan nanti.
- Upload gambar lewat helper optimasi jika masuk dari CMS.

### JavaScript

- Jangan menambah library besar untuk interaksi kecil.
- Hindari slider atau animasi berat di hero.
- Script pihak ketiga dipakai hanya jika benar-benar perlu.

## 11. Contoh Perubahan Umum

### Mengubah nama brand di navbar

File:

```text
resources/views/partials/navbar.blade.php
```

Cari:

```blade
Prestige <span class="text-brand-accent">In Media</span>
```

Ubah menjadi nama brand baru.

### Mengubah warna tombol utama

File:

```text
resources/css/guest.css
```

Cari:

```css
--color-brand-accent: #0D45FF;
```

Ubah nilai hex-nya.

### Mengubah judul hero

Cara CMS:

```text
/cms/hero -> Title -> Save Changes
```

Cara file tidak disarankan untuk judul hero utama, karena judul hero sudah disimpan di database.

### Mengubah background hero

Cara CMS:

```text
/cms/hero -> Background Image -> pilih gambar -> Save Changes
```

### Mengubah teks CTA

File:

```text
resources/views/sections/CTA.blade.php
```

Ubah teks:

```blade
Strategi Kreatif untuk
Brand yang Ingin
Naik Level
```

## 12. Ringkasan Paling Penting

Jika hanya ingin mengubah landing page:

1. Ubah konten utama dari CMS.
2. Ubah warna dan font dari `resources/css/guest.css`.
3. Ubah logo dari `resources/views/partials/navbar.blade.php`.
4. Ubah teks hard-coded dari file section di `resources/views/sections`.
5. Upload background hero lewat `/cms/hero`.
6. Jangan edit `public/build`.
7. Setelah CSS berubah, jalankan `npm.cmd run dev` atau `npm.cmd run build`.
8. Selalu pikirkan Core Web Vitals: gambar kecil, JavaScript sedikit, layout stabil.


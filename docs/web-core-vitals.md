# Dokumentasi Web Core Vitals

Dokumen ini menjelaskan teknik yang sudah dipakai di project untuk menjaga Core Web Vitals: LCP, INP, dan CLS. Fokusnya adalah halaman publik yang memakai Blade, Laravel, Tailwind, Vite, dan data dari CMS.

## Ringkasan Target

| Metric | Artinya | Target baik | Fokus di project |
| --- | --- | --- | --- |
| LCP | Seberapa cepat konten utama terbesar terlihat | <= 2.5 detik | Optimasi hero image, ukuran file gambar, font, dan asset build |
| INP | Seberapa cepat halaman merespons interaksi user | <= 200 ms | JavaScript ringan, interaksi sederhana, query data rapi |
| CLS | Seberapa stabil layout saat halaman dimuat | <= 0.1 | Ukuran gambar eksplisit, area hero stabil, font memakai `display=swap` |

Sumber referensi target: web.dev Core Web Vitals. Link resmi ada di bagian "Referensi Eksternal".

## Peta Kode

| Area | File | Peran |
| --- | --- | --- |
| Optimasi gambar upload | `app/Support/OptimizedImage.php:12` | Resize, kompres, convert ke WebP, orientasi EXIF |
| Upload hero CMS | `app/Livewire/CMS/Hero/Edit.php:15` | Validasi dan simpan hero image lewat `OptimizedImage` |
| Upload service CMS | `app/Livewire/CMS/Service/Form.php:18` | Validasi dan simpan service item image lewat `OptimizedImage` |
| Render hero publik | `resources/views/sections/hero.blade.php:6` | LCP image diberi ukuran, eager loading, fetch priority tinggi |
| Render service card | `resources/views/sections/services.blade.php:19` | Gambar bawah layar memakai lazy loading |
| Render service detail | `resources/views/pages/service-detail.blade.php:40` | Gambar detail memakai lazy loading dan ukuran eksplisit |
| Layout publik | `resources/views/layouts/guest.blade.php:6` | Viewport, preconnect font, font display swap, Vite assets |
| Build assets | `vite.config.js:9` dan `package.json:7` | Bundling CSS/JS dengan Vite dan Tailwind |
| Query halaman home | `app/Http/Controllers/Frontend/HomeController.php:19` | Eager loading relasi untuk mengurangi query tambahan |

## LCP: Largest Contentful Paint

LCP biasanya dipengaruhi oleh hero image, hero title, font, CSS utama, dan waktu server mengirim HTML.

### 1. Hero image diprioritaskan

Kode:

```blade
<img src="{{ asset('storage/' . $hero->background_image) }}" alt=""
    class="absolute inset-0 w-full h-full object-cover z-0" width="1920" height="1080" loading="eager"
    fetchpriority="high" decoding="async">
```

Lokasi: `resources/views/sections/hero.blade.php`

Fungsi atribut:

| Atribut | Kegunaan |
| --- | --- |
| `width="1920"` dan `height="1080"` | Memberi tahu browser rasio gambar sejak awal |
| `loading="eager"` | Hero image langsung dimuat karena terlihat di viewport awal |
| `fetchpriority="high"` | Browser memprioritaskan download hero image |
| `decoding="async"` | Decode gambar tidak menahan pekerjaan utama browser |

Cara pakai:

1. Pakai pola ini hanya untuk gambar utama yang muncul di layar pertama.
2. Jangan berikan `fetchpriority="high"` ke semua gambar.
3. Pastikan ukuran HTML sesuai ukuran hasil optimasi dari backend.

### 2. Gambar dioptimasi saat upload

Kode utama:

```php
public static function storeHeroBackground(UploadedFile $image): string
{
    return self::store($image, 'hero', 1920, 1080, 82);
}

public static function storeServiceItem(UploadedFile $image): string
{
    return self::store($image, 'services/items', 1200, 800, 82);
}
```

Lokasi: `app/Support/OptimizedImage.php`

Yang dilakukan helper:

| Method / proses | Dampak |
| --- | --- |
| `storeHeroBackground()` | Membatasi hero image maksimal 1920x1080 |
| `storeServiceItem()` | Membatasi service image maksimal 1200x800 |
| `imagecopyresampled()` | Resize gambar agar ukuran file lebih kecil |
| `imagewebp(..., 82)` | Convert ke WebP quality 82 |
| `orientImage()` | Memperbaiki orientasi JPEG dari EXIF |

Cara pakai di fitur baru:

```php
use App\Support\OptimizedImage;

$path = OptimizedImage::storeServiceItem($uploadedImage);
```

Kalau gambar baru adalah hero/banner layar pertama, pakai:

```php
$path = OptimizedImage::storeHeroBackground($uploadedImage);
```

### 3. Validasi upload membatasi gambar terlalu besar

Kode:

```php
private const IMAGE_RULES = [
    'nullable',
    'image',
    'mimes:jpg,jpeg,png,webp',
    'max:2048',
    'dimensions:max_width=3000,max_height=3000',
];
```

Lokasi:

- `app/Livewire/CMS/Hero/Edit.php`
- `app/Livewire/CMS/Service/Form.php`

Dampaknya:

- File mentah dibatasi maksimal 2 MB.
- Dimensi terlalu besar ditolak sebelum diproses.
- Format dibatasi ke format gambar umum.

### 4. Font dibuat lebih cepat siap

Kode:

```blade
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap"
    rel="stylesheet">
```

Lokasi: `resources/views/layouts/guest.blade.php`

Dampaknya:

- `preconnect` mempercepat koneksi awal ke server font.
- `display=swap` membuat teks tetap tampil memakai fallback font saat font utama belum selesai dimuat.

### 5. Asset dibundling oleh Vite

Kode:

```js
laravel({
    input: ['resources/css/app.css', 'resources/js/app.js'],
    refresh: true,
}),
tailwindcss(),
```

Lokasi: `vite.config.js`

Cara pakai:

- Development: `npm run dev` atau `bun run dev`
- Production build: `npm run build` atau `bun run build`

Di Blade, asset dipanggil lewat:

```blade
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

## INP: Interaction to Next Paint

INP dipengaruhi oleh berat JavaScript, event handler, update DOM, animasi, dan pekerjaan server yang memicu render ulang.

### 1. JavaScript publik sangat ringan

File `resources/js/app.js` saat ini kosong. Ini bagus untuk INP karena halaman publik tidak menjalankan banyak JavaScript custom.

Cara menjaga:

1. Tambahkan JavaScript hanya jika interaksi tidak bisa diselesaikan dengan HTML/CSS.
2. Hindari event listener global yang berat.
3. Untuk pekerjaan mahal, lakukan setelah interaksi selesai atau pecah menjadi tugas kecil.

### 2. Mobile menu memakai CSS-only toggle

Kode:

```blade
<input type="checkbox" id="mobile-menu-toggle" class="hidden peer">
<label for="mobile-menu-toggle"
    class="lg:hidden flex flex-col items-center justify-center w-10 h-10 cursor-pointer gap-1.5">
```

Lokasi: `resources/views/partials/navbar.blade.php`

Dampaknya:

- Tidak perlu JavaScript untuk membuka menu mobile.
- Interaksi menu tidak menambah beban event handler.

### 3. Livewire form memakai loading state

Contoh kode:

```blade
<button wire:click="save" wire:loading.attr="disabled">
    <span wire:loading.remove>Save</span>
    <span wire:loading>Saving...</span>
</button>
```

Lokasi contoh:

- `resources/views/livewire/cms/hero/edit.blade.php`
- `resources/views/livewire/cms/service/form.blade.php`
- `resources/views/livewire/cms/pricing/manage.blade.php`

Dampaknya:

- Tombol tidak diklik berulang saat request sedang berjalan.
- User mendapat feedback cepat.
- DOM update lebih terkontrol.

### 4. Data relasi diambil dengan eager loading

Kode:

```php
$services = Service::query()
    ->with('items')
    ->orderBy('sort_order')
    ->get();

$pricings = Pricing::query()
    ->with('benefits')
    ->orderBy('price')
    ->get();
```

Lokasi: `app/Http/Controllers/Frontend/HomeController.php`

Dampaknya:

- Mengurangi query berulang saat Blade melakukan loop.
- Membantu HTML awal lebih cepat selesai dibuat.
- Efek utamanya terasa di LCP/TTFB, tetapi juga membantu halaman tidak terasa berat saat data banyak.

## CLS: Cumulative Layout Shift

CLS terjadi saat elemen berpindah posisi setelah halaman terlihat.

### 1. Semua gambar publik penting diberi ukuran eksplisit

Contoh hero:

```blade
width="1920" height="1080"
```

Contoh service card:

```blade
width="640" height="384" loading="lazy" decoding="async"
```

Contoh service detail:

```blade
width="1200" height="800" loading="lazy" decoding="async"
```

Lokasi:

- `resources/views/sections/hero.blade.php`
- `resources/views/sections/services.blade.php`
- `resources/views/pages/service-detail.blade.php`

Dampaknya:

- Browser bisa menyisihkan ruang sebelum gambar selesai dimuat.
- Layout tidak meloncat ketika gambar muncul.

### 2. Area hero punya tinggi stabil

Kode:

```blade
<section class="relative min-h-screen flex items-center justify-center text-center overflow-hidden">
```

Lokasi: `resources/views/sections/hero.blade.php`

Dampaknya:

- Area above-the-fold punya tinggi minimal dari awal.
- Overlay, gambar, dan teks hero berada dalam container yang sudah stabil.

### 3. Gambar bawah layar memakai lazy loading

Kode:

```blade
loading="lazy" decoding="async"
```

Lokasi:

- `resources/views/sections/services.blade.php`
- `resources/views/pages/service-detail.blade.php`

Dampaknya:

- Browser tidak memprioritaskan gambar yang belum terlihat.
- Bandwidth awal fokus ke konten yang langsung dibutuhkan.

Catatan: lazy image tetap harus punya `width` dan `height` agar tidak menyebabkan CLS.

### 4. Animasi memakai opacity/transform

Kode:

```css
--animate-fade-in: fadeIn 0.5s ease-out forwards;
--animate-slide-up: slideUp 0.6s ease-out forwards;

@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}

@keyframes slideUp {
    0% { transform: translateY(20px); opacity: 0; }
    100% { transform: translateY(0); opacity: 1; }
}
```

Lokasi: `resources/css/app.css`

Dampaknya:

- `opacity` dan `transform` relatif aman untuk performa rendering.
- Hindari animasi properti layout seperti `width`, `height`, `top`, atau `left` untuk elemen besar.

## Cara Menambah Gambar Baru Tanpa Merusak Core Web Vitals

1. Validasi upload di Livewire/controller.
2. Simpan gambar lewat `App\Support\OptimizedImage`.
3. Render gambar dengan `width`, `height`, `alt`, dan `decoding="async"`.
4. Untuk gambar above-the-fold, gunakan `loading="eager"` dan boleh `fetchpriority="high"`.
5. Untuk gambar di bawah layar, gunakan `loading="lazy"`.
6. Jangan pakai `fetchpriority="high"` untuk gambar card/list/detail yang tidak muncul pertama.

Contoh Blade untuk gambar bawah layar:

```blade
<img
    src="{{ asset('storage/' . $item->image) }}"
    alt="{{ $item->title }}"
    width="1200"
    height="800"
    loading="lazy"
    decoding="async"
    class="w-full object-cover"
>
```

Contoh Blade untuk hero:

```blade
<img
    src="{{ asset('storage/' . $hero->background_image) }}"
    alt=""
    width="1920"
    height="1080"
    loading="eager"
    fetchpriority="high"
    decoding="async"
    class="absolute inset-0 h-full w-full object-cover"
>
```

## Checklist Review Sebelum Merge

Gunakan checklist ini saat menambah section, gambar, script, atau komponen baru.

### LCP

- Hero atau konten utama tidak menunggu JavaScript untuk tampil.
- Gambar utama sudah WebP dan dimensinya sesuai kebutuhan.
- Hanya satu gambar utama yang memakai `fetchpriority="high"`.
- Asset sudah lewat `@vite`.
- Query halaman tidak membuat N+1 query.

### INP

- JavaScript custom tetap kecil.
- Event handler tidak melakukan pekerjaan berat langsung di klik/input.
- Tombol async punya loading/disabled state.
- Animasi hover/transisi tidak mengubah layout besar.

### CLS

- Semua gambar punya `width` dan `height`.
- Slot konten dinamis punya ruang yang stabil.
- Font eksternal memakai `display=swap`.
- Lazy image tetap punya dimensi eksplisit.

## Yang Belum Ada dan Bisa Ditambahkan Nanti

Project sudah punya fondasi performa yang bagus, tetapi belum terlihat beberapa hal ini:

| Improvement | Alasan |
| --- | --- |
| Responsive image `srcset` dan `sizes` | Browser mobile bisa download gambar lebih kecil |
| Real User Monitoring untuk LCP/INP/CLS | Bisa melihat angka dari user nyata, bukan hanya lab test |
| Lighthouse CI atau budget performa | Mencegah regressions saat deploy |
| Cache headers untuk asset storage | Membantu repeat visit memuat gambar lebih cepat |
| Preload spesifik hero image | Bisa membantu LCP jika hero image selalu ada dan URL diketahui sejak render head |

## Cara Mengukur

Untuk pengukuran cepat:

1. Jalankan build production: `npm run build` atau `bun run build`.
2. Buka halaman utama.
3. Jalankan Lighthouse dari Chrome DevTools.
4. Cek LCP element: biasanya hero image atau hero heading.
5. Cek CLS diagnostics untuk elemen yang berpindah.
6. Cek INP/TBT diagnostics untuk JavaScript yang berat.

Untuk data user nyata, gunakan PageSpeed Insights atau Search Console Core Web Vitals setelah site online dan punya traffic cukup.

## Referensi Eksternal

- web.dev: https://web.dev/articles/vitals
- web.dev threshold methodology: https://web.dev/articles/defining-core-web-vitals-thresholds

<?php

use App\Livewire\CMS\About\Edit as AboutEdit;
use App\Livewire\CMS\Contact\Edit as ContactEdit;
use App\Livewire\CMS\Hero\Edit as HeroEdit;
use App\Livewire\CMS\Pricing\Manage as PricingManage;
use App\Livewire\CMS\Service\Index as ServiceIndex;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Models\Service;
use App\Http\Controllers\Frontend\HomeController;
use App\Livewire\CMS\Service\Form;
use App\Models\ContactSection;

/*
|--------------------------------------------------------------------------
| FRONTEND
|--------------------------------------------------------------------------
*/

// INDEX LANDING PAGE
Route::get('/', [HomeController::class, 'index'])
    ->name('home');


Route::get('/services/{slug}', function ($slug) {
    $service = Service::query()
        ->select(['id', 'title', 'slug', 'subtitle', 'description'])
        ->with(['items:id,service_id,title,subtitle,description,image,sort_order'])
        ->where('slug', $slug)
        ->firstOrFail();

    return view('pages.service-detail', compact('service'));
})->name('services.show');


/*
|--------------------------------------------------------------------------
| CMS (ADMIN)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    Route::livewire('/dashboard', Dashboard::class)
        ->name('dashboard');

    Route::prefix('cms')->name('cms.')->group(function () {

        Route::livewire('/hero', HeroEdit::class)
            ->name('hero');

        Route::livewire('/about', AboutEdit::class)
            ->name('about');

        Route::livewire('/services', ServiceIndex::class)
            ->name('services');

        Route::get('/services/create', Form::class)
            ->name('services.create');

        Route::get('/services/{service}/edit', Form::class)
            ->name('services.edit');


        Route::livewire('/pricing', PricingManage::class)
            ->name('pricing');

        Route::livewire('/contact', ContactEdit::class)
            ->name('contact');
    });
});


/*
|--------------------------------------------------------------------------
| SETTINGS (starter kit)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/settings.php';

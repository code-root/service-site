<?php

use Illuminate\Http\Request;
use App\Helpers\TranslationHelper;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\dashboard\FaqController;
use App\Http\Controllers\dashboard\HomeController;
use App\Http\Controllers\dashboard\PageController;
use App\Http\Controllers\dashboard\AdminController;
use App\Http\Controllers\dashboard\SliderController;
use App\Http\Controllers\dashboard\GalleryController;
use App\Http\Controllers\dashboard\SectionController;
use App\Http\Controllers\dashboard\ServiceController;
use App\Http\Controllers\dashboard\CategoryController;
use App\Http\Controllers\dashboard\SettingsController;
use App\Http\Controllers\dashboard\ImageItemController;
use App\Http\Controllers\dashboard\TestimonialController;
use App\Http\Controllers\dashboard\TranslationController;
use App\Http\Controllers\dashboard\SuccessPartnerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::post('storeText', function (Request $request) {
    $data = $request->all();
    return response()->json(TranslationHelper::storeText($data));
})->name('storeText');

    Route::get('getText', function (Request $request) {
        $languageId = $request->input('language_id');
        $token = $request->input('token');
        return response()->json(TranslationHelper::getText($languageId, $token));
    })->name('getText');



    Route::get('/clear', function () {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');
        return "Cleared cach , config , view , optimize !";
    });

    Route::get('view-image-success-partners/', [SuccessPartnerController::class, 'viewImage'])->name('api.image.partners');
    Route::get('/view-image/{m}', [SiteController::class, 'viewImage'])->name('view-image');
    Route::get('/service/{id}', [ServiceController::class, 'showServiceDetails'])->name('service.details');
    Route::get('service', [SiteController::class, 'indexService'])->name('service.home');
    Route::post('/service/subscribe', [SubscriberController::class, 'subscribe'])->name('service.subscribe');
    Route::group(['prefix' => 'dashboard'], function () {


    Route::get('/login', function () {
        return view('dashboard.auth.login');
    })->name('login');

    Route::post('/login', [AdminController::class, 'customLogin'])->name('login.custom');


    Route::get('/register', function () {
        return view('dashboard.auth.registration');
    })->name('register');
    Route::post('/register', [AdminController::class, 'register'])->name('register.post');


    Route::middleware('auth:web')->group(function () {
        Route::get('/logout', [AdminController::class, 'logout'])->name('login.logout');
        Route::get('/', [HomeController::class, 'index'])->name('dashboard-index');

        Route::get('translations', [TranslationController::class, 'index'])->name('translations.index');
        Route::post('translations/update', [TranslationController::class, 'update'])->name('translations.update');


        Route::group(['prefix' => 'admin'], function () {
            Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
            Route::post('profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
        });



        Route::get('contact', [ContactController::class, 'index'])->name('contacts.index');
        Route::delete('contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');


        Route::group(['prefix' => 'success-partners'], function () {
            Route::get('', [SuccessPartnerController::class, 'index'])->name('success_partners.index');
            Route::post('/store', [SuccessPartnerController::class, 'store'])->name('success_partners.store');
            Route::get('/edit/{id}', [SuccessPartnerController::class, 'edit'])->name('success_partners.edit');
            Route::put('/update/{id}', [SuccessPartnerController::class, 'update'])->name('success_partners.update');
            Route::delete('/destroy/{id}', [SuccessPartnerController::class, 'destroy'])->name('success_partners.destroy');
        });

        Route::group(['prefix' => 'testimonials'], function () {
            Route::get('', [TestimonialController::class, 'index'])->name('testimonials.index');
            Route::get('/data', [TestimonialController::class, 'data'])->name('testimonials.data');
            Route::post('/store', [TestimonialController::class, 'store'])->name('testimonials.store');
            Route::get('/edit/{id}', [TestimonialController::class, 'edit'])->name('testimonials.edit');
            Route::post('/update/{id}', [TestimonialController::class, 'update'])->name('testimonials.update');
            Route::delete('/delete/{id}', [TestimonialController::class, 'destroy'])->name('testimonials.delete');

        });


        Route::group(['prefix' => 'pages'], function () {
            Route::get('add', [PageController::class, 'create'])->name('dashboard.pages.create');
            Route::post('create', [PageController::class, 'createPage'])->name('dashboard.pages.save');
            Route::post('store', [PageController::class, 'store'])->name('pages.store');
            Route::get('/edit/{id}', [PageController::class, 'edit'])->name('pages.edit');
            Route::get('/', [PageController::class, 'index'])->name('pages.index');
            Route::get('/pages/id', [PageController::class, 'show'])->name('pages.show');
            Route::post('/pages/update', [PageController::class, 'update'])->name('dashboard.pages.update');
            Route::delete('/pages/destroy/{id}', [PageController::class, 'destroy'])->name('pages.destroy');
            Route::get('translations', [PageController::class, 'getTranslations'])->name('dashboard.pages.getTranslations');
        });

        // مسارات الخدمات (Service)
        Route::prefix('services')->group(function () {
            Route::get('/', [ServiceController::class, 'index'])->name('service.index');
            Route::get('/getData', [ServiceController::class, 'getData'])->name('service.data');
            Route::post('/create', [ServiceController::class, 'create'])->name('service.create');
            Route::get('/create', [ServiceController::class, 'createPage'])->name('service.create.page');
            Route::get('/edit/{id}', [ServiceController::class, 'edit'])->name('service.edit');
            Route::post('/update/{id}', [ServiceController::class, 'update'])->name('service.update');
            Route::delete('/destroy', [ServiceController::class, 'destroy'])->name('service.destroy');
            Route::post('/toggle-status', [ServiceController::class, 'toggleStatus'])->name('service.toggleStatus');
            Route::post('get-translations', [ServiceController::class, 'getTranslations'])->name('service.getTranslations');
        });

        Route::group(['prefix'=>'app-slider'], function(){
            Route::get('/', [SliderController::class, 'index'])->name('appSlider.index');
            Route::get('/getData', [SliderController::class, 'getData'])->name('appSlider.data');
            Route::get('/add', [SliderController::class, 'add'])->name('appSlider.add');
            Route::post('create', [SliderController::class, 'create'])->name('appSlider.create');
            Route::post('toggleStatus', [SliderController::class, 'toggleStatus'])->name('appSlider.toggleStatus');
            Route::get('edit/{id}', [SliderController::class, 'edit'])->name('appSlider.edit');
            Route::put('{id}/update', [SliderController::class, 'update'])->name('appSlider.update');
            Route::delete('/destroy', [SliderController::class, 'destroy'])->name('appSlider.destroy');
            Route::post('get-translations', [SliderController::class, 'getTranslations'])->name('appSlider.getTranslations');
        });



        Route::group(['prefix' => 'image'], function () {
            Route::post('/upload', [ImageItemController::class, 'store'])->name('image.upload');
            Route::post('delete', [ImageItemController::class, 'delete'])->name('image.delete');
        });


        Route::prefix('faq')->group(function () {
            Route::get('/', [FaqController::class, 'index'])->name('dashboard.faq.index');
            Route::get('/getData', [FaqController::class, 'getData'])->name('dashboard.faq.data');
            Route::post('/create', [FaqController::class, 'create'])->name('dashboard.faq.create');
            Route::get('/create', [FaqController::class, 'createPage'])->name('dashboard.faq.create.page');
            Route::get('/edit/{id}', [FaqController::class, 'edit'])->name('dashboard.faq.edit');
            Route::post('/update/{id}', [FaqController::class, 'update'])->name('dashboard.faq.update');
            Route::delete('/destroy', [FaqController::class, 'destroy'])->name('dashboard.faq.destroy');
            Route::post('/toggle-status', [FaqController::class, 'toggleStatus'])->name('dashboard.faq.toggleStatus');
            Route::post('get-translations', [FaqController::class, 'getTranslations'])->name('dashboard.faq.getTranslations');
        });


        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('category.index');
            Route::get('/getData', [CategoryController::class, 'getData'])->name('category.data');

            Route::post('/create', [CategoryController::class, 'create'])->name('category.create');
            Route::get('/create', [CategoryController::class, 'createPage'])->name('category.create.page');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');

            Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
            Route::delete('/destroy', [CategoryController::class, 'destroy'])->name('category.destroy');
            Route::post('/toggle-status', [CategoryController::class, 'toggleStatus'])->name('category.toggleStatus');
            Route::post('get-translations', [CategoryController::class, 'getTranslations'])->name('category.getTranslations');

        });
        Route::prefix('sections')->group(function () {
            Route::get('/', [SectionController::class, 'index'])->name('section.index');
            Route::get('/getData', [SectionController::class, 'getData'])->name('section.data');
            Route::post('/create', [SectionController::class, 'create'])->name('section.create');
            Route::get('/edit/{id}', [SectionController::class, 'edit'])->name('section.edit');
            Route::post('/update/{id}', [SectionController::class, 'update'])->name('section.update');
            Route::delete('/destroy', [SectionController::class, 'destroy'])->name('section.destroy');
            Route::post('/toggle-status', [SectionController::class, 'toggleStatus'])->name('section.toggleStatus');
            Route::get('/{section_id}/pages/create', [SectionController::class, 'createPages'])->name('page.create');
            Route::post('/{section_id}/pages/save', [SectionController::class, 'savePage'])->name('page.save');
        });

        // مسارات معرض الصور (Gallery)
        Route::prefix('galleries')->group(function () {
            Route::get('/', [GalleryController::class, 'index'])->name('gallery.index');
            Route::get('/getData', [GalleryController::class, 'getData'])->name('gallery.data');
            Route::post('/create', [GalleryController::class, 'create'])->name('gallery.create');
            Route::get('/edit/{id}', [GalleryController::class, 'edit'])->name('gallery.edit');
            Route::post('/update/{id}', [GalleryController::class, 'update'])->name('gallery.update');
            Route::delete('/destroy', [GalleryController::class, 'destroy'])->name('gallery.destroy');
            Route::post('/toggle-status', [GalleryController::class, 'toggleStatus'])->name('gallery.toggleStatus');
        });


        Route::group(['prefix' => 'settings'], function () {
            Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
            Route::get('get-fields', [SettingsController::class, 'getFields'])->name('settings.getFields');
            Route::post('update', [SettingsController::class, 'update'])->name('settings.update');
        });

    });
});

Route::get('set-locale/{locale}', [SiteController::class, 'setLocale'])->name('set.locale');
Route::get('/', [SiteController::class, 'home'])->name('home');
Route::post('contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('contact', [ContactController::class, 'contact'])->name('contact.index');
Route::get('page/{name}', [PageController::class, 'showPage'])->name('page.show');
Route::post('/subscribe', [SubscriberController::class, 'store']);

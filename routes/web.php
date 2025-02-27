<?php

use Illuminate\Http\Request;
use App\Helpers\TranslationHelper;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ImageItemController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\dashboard\AdminController;
use App\Http\Controllers\dashboard\License\ClientController;
use App\Http\Controllers\dashboard\License\LicenseController;
use App\Http\Controllers\dashboard\License\ProgramController;
use App\Http\Controllers\dashboard\License\SalesReportController;
use App\Http\Controllers\dashboard\site\FaqController;
use App\Http\Controllers\dashboard\site\PageController;
use App\Http\Controllers\dashboard\roles\RoleController;
use App\Http\Controllers\dashboard\roles\UserController;
use App\Http\Controllers\dashboard\site\SliderController;
use App\Http\Controllers\dashboard\site\GalleryController;
use App\Http\Controllers\dashboard\site\SectionController;
use App\Http\Controllers\dashboard\site\ServiceController;
use App\Http\Controllers\dashboard\site\CategoryController;
use App\Http\Controllers\dashboard\site\HomeController;
use App\Http\Controllers\dashboard\site\SettingsController;
use App\Http\Controllers\dashboard\site\TestimonialController;
use App\Http\Controllers\dashboard\site\TranslationController;
use App\Http\Controllers\dashboard\site\SuccessPartnerController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;


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
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');



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


    // Route::get('/register', function () {
    //     return view('auth.registration');
    // })->name('register');
    // Route::post('/register', [AdminController::class, 'register'])->name('register.post');


    Route::middleware('auth:web')->group(function () {

        Route::get('/logout', [AdminController::class, 'logout'])->name('login.logout');
        Route::get('/', [HomeController::class, 'index'])->name('dashboard.index');

        Route::get('translations', [TranslationController::class, 'index'])->name('translations.index');
        Route::post('translations/update', [TranslationController::class, 'update'])->name('translations.update');


        Route::group(['prefix' => 'admin'], function () {
            Route::post('/dashboard/profile/update-password', [AdminController::class, 'updatePassword'])->name('admin.profile.updatePassword');

        Route::post('/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
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

        Route::group(['prefix' => 'program'], function () {
            Route::get('', [ProgramController::class, 'index'])->name('program.index');
            Route::get('/create', [ProgramController::class, 'create'])->name('program.create');
            Route::post('/store', [ProgramController::class, 'store'])->name('program.store');
            Route::get('/edit/{id}', [ProgramController::class, 'edit'])->name('program.edit');
            Route::put('/update', [ProgramController::class, 'update'])->name('program.update');
            Route::delete('/destroy/{id}', [ProgramController::class, 'destroy'])->name('program.destroy');
            Route::patch('/toggle-status/{id}', [ProgramController::class, 'toggleStatus'])->name('program.toggleStatus');
            Route::get('/data', [ProgramController::class, 'getData'])->name('program.data'); // لإرجاع البيانات للـ DataTable
        });

        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);



        Route::group(['prefix' => 'license'], function () {
            Route::get('', [LicenseController::class, 'index'])->name('license.index');
            Route::get('/create', [LicenseController::class, 'create'])->name('license.create');
            Route::post('/store', [LicenseController::class, 'store'])->name('licenses.store');
            Route::get('/edit/{id}', [LicenseController::class, 'edit'])->name('license.edit');
            Route::put('/update/{id}', [LicenseController::class, 'update'])->name('license.update');
            Route::delete('/destroy/{id}', [LicenseController::class, 'destroy'])->name('license.destroy');
        });


        Route::group(['prefix' => 'clients'], function () {
            Route::get('', [ClientController::class, 'index'])->name('clients.index');
            Route::get('/create', [ClientController::class, 'create'])->name('clients.create');
            Route::post('/store', [ClientController::class, 'store'])->name('clients.store');
            Route::get('/edit/{id}', [ClientController::class, 'edit'])->name('clients.edit');
            Route::put('/update', [ClientController::class, 'update'])->name('clients.update');
            Route::delete('/destroy/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
            Route::patch('/toggle-status/{id}', [ClientController::class, 'toggleStatus'])->name('clients.toggleStatus');
            Route::get('data', [ClientController::class, 'getData'])->name('clients.data');
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
            Route::get('add', [PageController::class, 'create'])->name('pages.create');
            Route::post('create', [PageController::class, 'createPage'])->name('pages.save');
            Route::post('store', [PageController::class, 'store'])->name('pages.store');
            Route::get('/edit/{id}', [PageController::class, 'edit'])->name('pages.edit');
            Route::get('/', [PageController::class, 'index'])->name('pages.index');
            Route::get('/pages/id', [PageController::class, 'show'])->name('pages.show');
            Route::post('/pages/update', [PageController::class, 'update'])->name('pages.update');
            Route::delete('/pages/destroy/{id}', [PageController::class, 'destroy'])->name('pages.destroy');
            Route::get('translations', [PageController::class, 'getTranslations'])->name('pages.getTranslations');
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



        Route::get('/sales-reports', [SalesReportController::class, 'index'])->name('sales.reports');
        Route::get('/sales-data', [SalesReportController::class, 'getSalesData'])->name('sales.data');
        Route::get('/sales', [SalesReportController::class, 'salesData'])->name('sales.dd');

        Route::group(['prefix' => 'image'], function () {
            Route::post('/upload', [ImageItemController::class, 'store'])->name('image.upload');
            Route::post('delete', [ImageItemController::class, 'delete'])->name('image.delete');
        });


        Route::prefix('faq')->group(function () {
            Route::get('/', [FaqController::class, 'index'])->name('faq.index');
            Route::get('/getData', [FaqController::class, 'getData'])->name('faq.data');
            Route::post('/create', [FaqController::class, 'create'])->name('faq.create');
            Route::get('/create', [FaqController::class, 'createPage'])->name('faq.create.page');
            Route::get('/edit/{id}', [FaqController::class, 'edit'])->name('faq.edit');
            Route::post('/update/{id}', [FaqController::class, 'update'])->name('faq.update');
            Route::delete('/destroy', [FaqController::class, 'destroy'])->name('faq.destroy');
            Route::post('/toggle-status', [FaqController::class, 'toggleStatus'])->name('faq.toggleStatus');
            Route::post('get-translations', [FaqController::class, 'getTranslations'])->name('faq.getTranslations');
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

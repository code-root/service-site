<?php

use Illuminate\Http\Request;
use App\Helpers\TranslationHelper;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ImageItemController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\dashboard\AdminController;
use App\Http\Controllers\dashboard\License\ClientController;
use App\Http\Controllers\dashboard\License\LicenseController;
use App\Http\Controllers\dashboard\License\ProgramController;
use App\Http\Controllers\dashboard\License\SalesReportController;
use App\Http\Controllers\dashboard\roles\RoleController;
use App\Http\Controllers\dashboard\roles\UserController;
use App\Http\Controllers\dashboard\site\ServiceController;
use App\Http\Controllers\dashboard\site\CategoryController;
use App\Http\Controllers\dashboard\site\HomeController;
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

    Route::get('/view-image/{m}', [SiteController::class, 'viewImage'])->name('view-image');
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



        Route::group(['prefix' => 'admin'], function () {
            Route::post('/dashboard/profile/update-password', [AdminController::class, 'updatePassword'])->name('admin.profile.updatePassword');

        Route::post('/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
            Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
            Route::post('profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
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
            Route::get('licenses/data', [LicenseController::class, 'getData'])->name('licenses.data');
            Route::get('', [LicenseController::class, 'index'])->name('license.index');
            Route::get('/create', [LicenseController::class, 'create'])->name('license.create');
            Route::post('/store', [LicenseController::class, 'store'])->name('licenses.store');
            Route::get('/edit/{id}', [LicenseController::class, 'edit'])->name('license.edit');
            Route::put('/update/{id}', [LicenseController::class, 'update'])->name('license.update');
            Route::delete('/destroy/{id}', [LicenseController::class, 'destroy'])->name('license.destroy');
            Route::post('/encrypt', [LicenseController::class, 'encrypt'])->name('licenses.encrypt');

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


        Route::get('/sales-reports', [SalesReportController::class, 'index'])->name('sales.reports');
        Route::get('/sales-data', [SalesReportController::class, 'getSalesData'])->name('sales.data');
        Route::get('/getSalesReportData', [SalesReportController::class, 'getSalesReportData'])->name('getSalesReportData');
        Route::get('/sales', [SalesReportController::class, 'salesData'])->name('sales.dd');

        Route::group(['prefix' => 'image'], function () {
            Route::post('/upload', [ImageItemController::class, 'store'])->name('image.upload');
            Route::post('delete', [ImageItemController::class, 'delete'])->name('image.delete');
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




    });
});

Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

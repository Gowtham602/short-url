<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\UrlShortenerController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\SmsCreditController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| PUBLIC HOME
|--------------------------------------------------------------------------
|
| Guest users can access the main Image Merger page.
|
*/

Route::get('/', [ImageController::class, 'publicDashboard'])
    ->name('home');


/*
|--------------------------------------------------------------------------
| IMAGE MERGER - PUBLIC
|--------------------------------------------------------------------------
|
| No login required.
|
*/


// Image Merger page
Route::get('/dashboard', [ImageController::class, 'publicDashboard'])
    ->name('dashboard');


// Process uploaded images
Route::post('/process-images', [ImageController::class, 'process'])
    ->name('image.process');


// Save generated image + create short URL
Route::post('/save-image', [ImageController::class, 'saveImage'])
    ->name('save.image');



/*
|--------------------------------------------------------------------------
| URL SHORTENER - PUBLIC
|--------------------------------------------------------------------------
|
| Guest users can create short URLs.
|
*/


// URL Shortener page
Route::get(
    '/url-shortener',
    [ImageController::class, 'urlShortener']
)->name('url-shortener.index');


// Create short URL
Route::post(
    '/url-shortener',
    [ImageController::class, 'saveUrl']
)->name('url-shortener.store');



/*
|--------------------------------------------------------------------------
| PDF → IMAGE - PUBLIC
|--------------------------------------------------------------------------
|
| Guest users can upload and process PDF files.
|
*/


// PDF page
Route::get(
    '/pdf',
    [PdfController::class, 'index']
)->name('pdf.index');


// Upload PDF
Route::post(
    '/pdf/upload',
    [PdfController::class, 'upload']
)->name('pdf.upload');


// Add image
Route::post(
    '/pdf/add-image',
    [PdfController::class, 'addImage']
)->name('pdf.add.image');


// Delete PDF page
Route::post(
    '/pdf/delete-page',
    [PdfController::class, 'deletePage']
)->name('pdf.delete.page');


// Reorder pages
Route::post(
    '/pdf/reorder',
    [PdfController::class, 'reorder']
)->name('pdf.reorder');


// Get PDF pages
Route::get(
    '/pdf/pages',
    [PdfController::class, 'pages']
)->name('pdf.pages');


// Generate final image
Route::post(
    '/pdf/generate',
    [PdfController::class, 'generate']
)->name('pdf.generate');


// Save final PDF-generated image
Route::post(
    '/pdf/save-image',
    [PdfController::class, 'saveImage']
)->name('pdf.save.image');


// PDF image list
Route::get(
    '/pdf/data-list',
    [PdfController::class, 'list']
)->name('images.list');



/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
|
| These routes require login.
|
*/

Route::middleware(['auth'])->group(function () {


    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN + ADMIN
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:super-admin,admin')->group(function () {


        /*
        |--------------------------------------------------------------------------
        | MOBILE ANALYTICS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/next',
            [ImageController::class, 'mobile']
        )->name('next');


        /*
        |--------------------------------------------------------------------------
        | IMAGE MANAGEMENT
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/get-images',
            [ImageController::class, 'getImages']
        )->name('get.images');


        Route::get(
            '/image/{short_code}/edit',
            [ImageController::class, 'edit']
        )->name('image.edit');


        Route::put(
            '/image/{short_code}',
            [ImageController::class, 'update']
        )->name('image.update');


        Route::delete(
            '/image/{id}',
            [ImageController::class, 'destroy']
        )->name('image.destroy');


        /*
        |--------------------------------------------------------------------------
        | OLD IMAGE UPLOAD
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/upload',
            [ImageController::class, 'store']
        )->name('image.upload');

    });



    /*
    |--------------------------------------------------------------------------
    | SMS CREDIT
    |--------------------------------------------------------------------------
    |
    | Role names should match your database:
    | super-admin, admin, staff
    |
    */

    Route::middleware('role:super-admin,admin,staff')->group(function () {


        // SMS Credit page
        Route::get(
            '/sms-credit',
            [SmsCreditController::class, 'index']
        )->name('sms.index');


        // Save SMS credit
        Route::post(
            '/sms-credit/store',
            [SmsCreditController::class, 'store']
        )->name('sms.store');


        // SMS list
        Route::get(
            '/sms/list',
            [SmsCreditController::class, 'list']
        )->name('sms.list');

    });



    /*
    |--------------------------------------------------------------------------
    | SMS REPORTS
    |--------------------------------------------------------------------------
    |
    | super-admin / admin / staff / auditor
    |
    */

    Route::middleware(
        'role:super-admin,admin,staff,auditor'
    )->group(function () {


        // Report page
        Route::get(
            '/sms-credit/report',
            [SmsCreditController::class, 'report']
        )->name('sms.report');


        // Report data
        Route::post(
            '/sms-credit/report/data',
            [SmsCreditController::class, 'reportData']
        )->name('sms.report.data');


        // Report PDF
        Route::get(
            '/sms-credit/report/pdf',
            [SmsCreditController::class, 'reportPdf']
        )->name('sms.report.pdf');


        // Report Excel
        Route::get(
            '/sms-credit/report/excel',
            [SmsCreditController::class, 'reportExcel']
        )->name('sms.report.excel');

    });



    /*
    |--------------------------------------------------------------------------
    | IMAGE LIST / ANALYTICS
    |--------------------------------------------------------------------------
    |
    | super-admin / admin / auditor
    |
    */

    Route::middleware(
        'role:super-admin,admin,auditor'
    )->group(function () {


        // Image list
        Route::get(
            '/admin/get-images',
            [ImageController::class, 'getImages']
        )->name('admin.get.images');


        // Image analysis
        Route::get(
            '/image/{image}/analysis',
            [ImageController::class, 'analysis']
        )->name('image.analysis');


        // Today's viewers
        Route::get(
            '/today-viewers/{image}',
            [ImageController::class, 'todayViewers']
        )->name('today.viewers');

    });

});



/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {


    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');


    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');


    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

});



/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';



/*
|--------------------------------------------------------------------------
| PUBLIC SHORT URL
|--------------------------------------------------------------------------
|
*/
Route::get('/{code}', [ImageController::class, 'redirect'])
    ->where('code', '[A-Za-z0-9]{5}')
    ->name('short.url');
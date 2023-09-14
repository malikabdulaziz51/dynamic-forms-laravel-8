<?php

use App\Http\Controllers\admin\AdminSettingsController;
use App\Http\Controllers\admin\BeritaController;
use App\Http\Controllers\admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\Form;
use App\Http\Controllers\admin\GalleryController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\ThemeSettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(
    ["prefix" => "/admin", "as" => "admin.", "middleware" => "auth"],
    function () {
        //dashboard
        Route::get("/dashboard", [DashboardController::class, 'index'], [
            "title" => "Dashboard",
        ])->name("dashboard");

        //berita
        Route::prefix("berita")->group(function () {
            Route::view("/", "pages.admin.berita", [
                "title" => "Berita",
            ])->name("berita");
            Route::get(
                "/add-berita",
                [BeritaController::class, 'addBerita'],
            )->name('add-berita');
            Route::post(
                "create-berita",
                [BeritaController::class, 'createBerita'],
            )->name("create-berita");
            Route::get(
                "edit-berita/{berita}",
                [BeritaController::class, 'editBerita'],
            )->name("edit-berita");
            Route::put(
                "update-berita/{berita}",
                [BeritaController::class, 'updateBerita'],
            )->name("update-berita");
        });

        //category
        Route::view("/categories", "pages.admin.categories", [
            "title" => "Kategori",
        ])->name("categories");

        //tags
        Route::view("/tags", "pages.admin.tags", [
            "title" => "Tags",
        ])->name("tags");

        Route::prefix("user")->group(function () {
            Route::view("/users", "pages.admin.users", [
                "title" => "Manajemen User",
            ])->name("users");
        });

        //gallery
        Route::prefix("gallery")->group(function () {
            Route::view("/", "pages.admin.gallery", [
                "title" => "Galeri",
            ])->name("gallery");

            Route::get('/details/{id}', [GalleryController::class, 'show'])->name('gallery-details');

            Route::post('/upload/{galleryId}', [GalleryController::class, 'upload'])->name('gallery.upload');

            Route::get('/fetch/{galleryId}', [GalleryController::class, 'fetch'])->name('gallery.fetch');

            Route::get('/delete/{galleryId}', [GalleryController::class, 'delete'])->name('gallery.delete');
        });


        //teachers
        Route::prefix("teachers")->group(function () {
            Route::view("/", "pages.admin.teachers", ["title" => "Guru dan Staff"])->name("teachers");

            Route::get(
                "/add-teacher",
                [App\Http\Controllers\admin\TeacherController::class, 'addTeacher'],
            )->name('add-teacher');

            Route::post(
                "store-teacher",
                [App\Http\Controllers\admin\TeacherController::class, 'storeTeacher'],
            )->name("store-teacher");

            Route::get(
                "edit-teacher/{teacher}",
                [App\Http\Controllers\admin\TeacherController::class, 'editTeacher'],
            )->name("edit-teacher");

            Route::put(
                "update-teacher/{teacher}",
                [App\Http\Controllers\admin\TeacherController::class, 'updateTeacher'],
            )->name("update-teacher");
        });

        Route::prefix("settings")->group(function () {
            Route::prefix('theme')->name("theme.")->group(function () {
                Route::view('/', 'pages.admin.theme-setting', ['title' => "Tema Website"])->name('settings');
                Route::put('update', [ThemeSettingController::class, 'updateTheme'])->name('updateTheme');
            });

            Route::prefix('information')->name("information.")->group(function () {
                Route::get('/', [SettingController::class, 'index'])->name('settings');
                Route::post('store', [SettingController::class, 'store'])->name('createorupdate-setting');
            });
        });


        Route::prefix('ppdb')->name('ppdb.')->group(function () {
            Route::get('/form_ppdb', [App\Http\Controllers\admin\Form\BuilderController::class, 'index'])->name('form_ppdb');

            Route::get('create', [App\Http\Controllers\admin\Form\BuilderController::class, 'create']);
            Route::post('store', [App\Http\Controllers\admin\Form\BuilderController::class, 'store'])->name('store');
            Route::get('edit/{id}', [App\Http\Controllers\admin\Form\BuilderController::class, 'edit'])->name('edit');
            Route::put('update/{id}', [App\Http\Controllers\admin\Form\BuilderController::class, 'update'])->name('update_form');
        });
    }
);


Route::prefix('form')->name('form.')->group(function () {
    Route::get('create', [App\Http\Controllers\site\FormController::class, 'create']);
    Route::post('store', [App\Http\Controllers\site\FormController::class, 'store'])->name('store');
});

Route::get("/", [App\Http\Controllers\site\HomeController::class, 'index'])->name('home');

Route::get("/berita", [
    \App\Http\Controllers\site\BeritaController::class, 'index'
]);

Route::get("/berita/{id}", [\App\Http\Controllers\site\BeritaController::class, 'detail']);

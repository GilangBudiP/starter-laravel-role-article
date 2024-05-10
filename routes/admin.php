<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ToolBoxController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\RoomPriceController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\ServiceController;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('users', function () {
        return view('admin.users.index');
    });
    Route::resources([
        'roles' => RoleController::class,
        'permissions' => PermissionController::class,
        'categories' => CategoryController::class,
        'users' => UserController::class,
    ]);

    // Upload image article
    Route::post('upload/{model}', [UploadController::class, 'store'])->name('upload');
    Route::delete('upload/{model}', [UploadController::class, 'destroy'])->name('upload.destroy');
    Route::delete('upload/{model}/{folder}/tmp', [UploadController::class, 'destroyTmp'])->name('upload.tmp.destroy');
    Route::get('upload/{model}/{folder}', [UploadController::class, 'restore'])->name('upload.restore');

    Route::post('images', [ImageController::class, 'store'])->name('images.store');
    Route::delete('rooms/images/{id}/{name}', [ImageController::class, 'destroy'])->name('images.destroy');
    Route::put('users/{user}/change-password', [UserController::class, 'changePassword'])->name('users.change-password');
    Route::get('dashboard', [DashboardController::class, 'index'])->withoutMiddleware('auth.active')->name('dashboard');
    Route::resource('galleries', GalleryController::class);
    Route::delete('galleries/{gallery}/images/{image}', [GalleryController::class, 'destroyImage'])->name('galleries.destroy-image');
    Route::resource('articles', ArticleController::class);
    Route::delete('articles/{article}/images/{image}', [ArticleController::class, 'destroyImage'])->name('articles.destroy-image');
    Route::post('users/{user}/suspend', [UserController::class, 'suspend'])->name('users.suspend');
    Route::post('users/{user}/unsuspend', [UserController::class, 'unsuspend'])->name('users.unsuspend');
});

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

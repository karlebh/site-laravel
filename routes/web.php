<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
});


Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
  Route::get('/profile/{user:name}', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
  Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
  Route::match(['post', 'patch'], '/profile-image', [\App\Http\Controllers\ProfileController::class, 'profileImage'])->name('profile.image');
  Route::delete('/profile-image/{user:id}', [\App\Http\Controllers\ProfileController::class, 'removeProfilePicture'])->name('profile.image.delete');



  Route::post('/follow/{user}', [\App\Http\Controllers\FollowController::class, 'store'])->name('follow');
  Route::post('/message', [\App\Http\Controllers\MessageController::class, 'store'])->name('message.store');
  Route::get('/message/{user}', [\App\Http\Controllers\MessageController::class, 'show'])->name('message.show');

  Route::view('/notification', 'notification.show')->name('notifications');
});


Route::resource('/post', \App\Http\Controllers\PostController::class);
Route::resource('/category', \App\Http\Controllers\CategoryController::class);
Route::resource('/comment', \App\Http\Controllers\CommentController::class);

Route::post('/like', [\App\Http\Controllers\LikeController::class, 'store'])->middleware('auth');
Route::delete('/like', [\App\Http\Controllers\LikeController::class, 'destroy'])->middleware('auth');


Route::delete('/image/{image}', [\App\Http\Controllers\ImageController::class, 'destroy']);

Route::post('/search', [\App\Http\Controllers\SearchController::class, 'search']);
// Route::post('/show-search', [\App\Http\Controllers\SearchController::class, 'show']);

Route::get('/users', [\App\Http\Controllers\UserController::class, 'show'])->name('users');

Route::delete('/notification/{id?}', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('nots.delete');
Route::put('/settings/{user_id}', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
// Route::match(['post', 'patch'], '/profile-picture', [\App\Http\Controllers\ProfileController::class, 'profilePicture'])->name('profile-picture');


Route::get('/admin', function () {
  return view('admin.show');
})->middleware('admin');










require __DIR__ . '/auth.php';

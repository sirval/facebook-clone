<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserDetailController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
// Route::get('/', [HomeController::class, 'index'])->name('welcome');

Auth::routes();

Route::controller(HomeController::class)->group(function () {
    Route::get('/home',  'index')->name('home');
    Route::post('/publish-post',  'publishPost')->name('publish.post');
    Route::patch('/edit-post/{id}',  'editPost')->name('edit.post');
    Route::get('/fetch-posts',  'getPosts')->name('fetch.posts');
    Route::post('/react/{id}',  'likeUnlikePost')->name('like.unlike');
    Route::post('/notification-read',  'markAllRead')->name('notification.read');
    Route::get('/user-profile/{user_id}',  'userDetail')->name('user.profile');
    Route::post('/edit-profile',  'editUserProfile')->name('edit.user');
    Route::delete('/post-delete/{id}',  'deletePost')->name('delete.post');
    Route::post('/comment',  'createComment')->name('comment.post');
    Route::post('/like-comment/{id}',  'likeUnlikeComment')->name('like.comment');
    Route::patch('/comment-edit/{id}',  'editComment')->name('edit.comment');
    Route::delete('/comment-delete/{id}',  'deleteComment')->name('delete.comment');
    Route::get('/user-roles',  'getUserWithRolesAndPermissions')->name('user.roles');
});

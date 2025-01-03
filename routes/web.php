<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/users', [App\Http\Controllers\User\UserController::class, 'index'])->name('users.index');
    Route::get('/user/create', [App\Http\Controllers\User\UserController::class, 'create'])->name('users.create');
    Route::get('/user/{id}/edit', [App\Http\Controllers\User\UserController::class, 'edit'])->name('users.edit');
    Route::post('/user', [App\Http\Controllers\User\UserController::class, 'store'])->name('users.store');
    Route::put('/user/{id}', [App\Http\Controllers\User\UserController::class, 'update'])->name('users.update');
    Route::delete('/user/{id}', [App\Http\Controllers\User\UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/groups', [App\Http\Controllers\Group\GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [App\Http\Controllers\Group\GroupController::class, 'create'])->name('groups.create');
    Route::get('/groups/{id}/edit', [App\Http\Controllers\Group\GroupController::class, 'edit'])->name('groups.edit');
    Route::post('/groups', [App\Http\Controllers\Group\GroupController::class, 'store'])->name('groups.store');
    Route::put('/groups/{id}', [App\Http\Controllers\Group\GroupController::class, 'update'])->name('groups.update');
    Route::delete('/groups/{id}', [App\Http\Controllers\Group\GroupController::class, 'destroy'])->name('groups.destroy');

    Route::get('/roles', [App\Http\Controllers\User\RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [App\Http\Controllers\User\RoleController::class, 'create'])->name('roles.create');
    Route::get('/roles/{id}/edit', [App\Http\Controllers\User\RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/roles', [App\Http\Controllers\User\RoleController::class, 'store'])->name('roles.store');
    Route::put('/roles/{id}', [App\Http\Controllers\User\RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{id}', [App\Http\Controllers\User\RoleController::class, 'destroy'])->name('roles.destroy');
});
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

    Route::get('/modules', [App\Http\Controllers\Module\ModuleController::class, 'index'])->name('modules.index');
    Route::get('/modules/create', [App\Http\Controllers\Module\ModuleController::class, 'create'])->name('modules.create');
    Route::get('/modules/{id}/edit', [App\Http\Controllers\Module\ModuleController::class, 'edit'])->name('modules.edit');
    Route::post('/modules', [App\Http\Controllers\Module\ModuleController::class, 'store'])->name('modules.store');
    Route::put('/modules/{id}', [App\Http\Controllers\Module\ModuleController::class, 'update'])->name('modules.update');
    Route::delete('/modules/{id}', [App\Http\Controllers\Module\ModuleController::class, 'destroy'])->name('modules.destroy');

    Route::get('/chapters', [App\Http\Controllers\Module\ChapterController::class, 'index'])->name('chapters.index');
    Route::get('/chapters/module/{fk_module}', [App\Http\Controllers\Module\ChapterController::class, 'show'])->name('chapters.show');
    Route::get('/chapters/module/{id}/details', [App\Http\Controllers\Module\ChapterController::class, 'details'])->name('chapters.details');
    Route::get('/chapters/create', [App\Http\Controllers\Module\ChapterController::class, 'create'])->name('chapters.create');
    Route::get('/chapters/{id}/edit', [App\Http\Controllers\Module\ChapterController::class, 'edit'])->name('chapters.edit');
    Route::post('/chapters', [App\Http\Controllers\Module\ChapterController::class, 'store'])->name('chapters.store');
    Route::put('/chapters/{id}', [App\Http\Controllers\Module\ChapterController::class, 'update'])->name('chapters.update');
    Route::delete('/chapters/{id}', [App\Http\Controllers\Module\ChapterController::class, 'destroy'])->name('chapters.destroy');

    Route::get('/videos', [App\Http\Controllers\Module\ChapterVideoController::class, 'index'])->name('videos.index');
    Route::get('/videos/create', [App\Http\Controllers\Module\ChapterVideoController::class, 'create'])->name('videos.create');
    Route::get('/videos/{id}/edit', [App\Http\Controllers\Module\ChapterVideoController::class, 'edit'])->name('videos.edit');
    Route::post('/videos', [App\Http\Controllers\Module\ChapterVideoController::class, 'store'])->name('videos.store');
    Route::put('/videos/{id}', [App\Http\Controllers\Module\ChapterVideoController::class, 'update'])->name('videos.update');
    Route::delete('/videos/{id}', [App\Http\Controllers\Module\ChapterVideoController::class, 'destroy'])->name('videos.destroy');
    
    Route::get('/records', [App\Http\Controllers\Record\RecordController::class, 'index'])->name('records.index');
    Route::get('/records/create', [App\Http\Controllers\Record\RecordController::class, 'create'])->name('records.create');
    Route::get('/records/show/{id}', [App\Http\Controllers\Record\RecordController::class, 'show'])->name('records.show');
    Route::get('/records/{id}/edit', [App\Http\Controllers\Record\RecordController::class, 'edit'])->name('records.edit');
    Route::post('/records', [App\Http\Controllers\Record\RecordController::class, 'store'])->name('records.store');
    Route::put('/records/{id}', [App\Http\Controllers\Record\RecordController::class, 'update'])->name('records.update');
    Route::delete('/records/{id}', [App\Http\Controllers\Record\RecordController::class, 'destroy'])->name('records.destroy');

    Route::get('/files', [App\Http\Controllers\File\FileController::class, 'index'])->name('files.index');
    Route::get('/files/create', [App\Http\Controllers\File\FileController::class, 'create'])->name('files.create');
    Route::get('/files/show/{id}', [App\Http\Controllers\File\FileController::class, 'show'])->name('files.show');
    Route::get('/files/{id}/edit', [App\Http\Controllers\File\FileController::class, 'edit'])->name('files.edit');
    Route::post('/files', [App\Http\Controllers\File\FileController::class, 'store'])->name('files.store');
    Route::put('/files/{id}', [App\Http\Controllers\File\FileController::class, 'update'])->name('files.update');
    Route::delete('/files/{id}', [App\Http\Controllers\File\FileController::class, 'destroy'])->name('files.destroy');

    Route::get('/cert', [App\Http\Controllers\Cert\CertificateController::class, 'index'])->name('cert.index');
    Route::get('/cert/users', [App\Http\Controllers\Cert\CertificateController::class, 'certificate'])->name('cert.user.index');
    Route::get('/cert/{id}/users', [App\Http\Controllers\Cert\CertificateController::class, 'users'])->name('cert.users');
    Route::get('/cert/{fk_cert}/{fk_user}/generate', [App\Http\Controllers\Cert\CertificateController::class, 'generate'])->name('cert.generate');
    Route::get('/cert/create', [App\Http\Controllers\Cert\CertificateController::class, 'create'])->name('cert.create');
    Route::get('/cert/show/{id}', [App\Http\Controllers\Cert\CertificateController::class, 'show'])->name('cert.show');
    Route::get('/cert/{id}/edit', [App\Http\Controllers\Cert\CertificateController::class, 'edit'])->name('cert.edit');
    Route::post('/cert', [App\Http\Controllers\Cert\CertificateController::class, 'store'])->name('cert.store');
    Route::put('/cert/{id}', [App\Http\Controllers\Cert\CertificateController::class, 'update'])->name('cert.update');
    Route::delete('/cert/{id}', [App\Http\Controllers\Cert\CertificateController::class, 'destroy'])->name('cert.destroy');
});
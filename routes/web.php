<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContatoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\TiigoController;
use App\Http\Controllers\UserController;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () { 
        return view('home');
    })->name('home');

    Route::get('/usuarios/criar', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios/store', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/lista', [UserController::class, 'lista'])->name('users.list');
    // Rota para editar um usuário
    Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])->name('users.edit');
    // Rota para salvar as alterações (opcional, dependendo do CRUD)
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('users.update');
});

Route::get('/esqueci', function () {
    return view('auth.esqueci');
})->name('esqueci-a-senha');

Route::get('/redefinir', function () {
    return view('auth.redefinir');
})->name('redefinir-senha');

Route::post('/send', [ContatoController::class, 'send'])->name('contato.send');
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
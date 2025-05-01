<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContatoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VendasController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\EstimativoController;
use App\Http\Controllers\LogisticaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ViajesController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\VoucherLoginController;
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
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/usuarios/criar', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios/store', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/lista', [UserController::class, 'lista'])->name('users.list');
    // Rota para editar um usuário
    Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])->name('users.edit');
    // Rota para salvar as alterações (opcional, dependendo do CRUD)
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/{id}/photo', [HomeController::class, 'updatePhoto'])->name('users.updatePhoto');

    Route::get('/vendas/list', [VendasController::class, 'index'])->name('vendas.list');
    Route::get('/vendas/create', [VendasController::class, 'create'])->name('vendas.create');
    Route::post('/vendas', [VendasController::class, 'store'])->name('vendas.store');

    Route::get('/tours', [TourController::class, 'index'])->name('tours.list');

    Route::get('/tours/create', [TourController::class, 'create'])->name('tours.create');
    Route::post('/tours', [TourController::class, 'store'])->name('tours.store');

    // Rota para editar um tour existente
    Route::get('/tours/{id}/edit', [TourController::class, 'edit'])->name('tours.edit');
    Route::put('/tours/{id}', [TourController::class, 'update'])->name('tours.update');

    Route::get('/estimativo', [EstimativoController::class, 'index'])->name('estimativo.index');
    
    Route::get('/logistica', [LogisticaController::class, 'index'])->name('logistica.index');
    Route::get('logistics/{logistica}/edit', [LogisticaController::class, 'edit'])->name('logistics.edit');

    // Rota para atualizar múltiplas logísticas
    Route::post('/logistics/assign', [LogisticaController::class, 'assign'])->name('logistics.assign');
    Route::post('/logistics/assignagencia', [LogisticaController::class, 'assignagencia'])->name('logistics.assignagencia');
    Route::post('/logistics/hora', [LogisticaController::class, 'hora'])->name('logistics.hora');
    Route::post('/logistics/export/pdf', [LogisticsController::class, 'exportPdf'])->name('logistics.export.pdf');
    Route::post('/logistics/{id}/update', [LogisticaController::class, 'update'])->name('logistics.update');
    Route::get('/pagos-full', [PagoController::class, 'index'])->name('pagos.full');
    Route::get('/viajes-full', [ViajesController::class, 'index'])->name('viajes.full');
    Route::post('/viajes-full/update-status/{id}', [ViajesController::class, 'updateStatus']);

    Route::get('/viajes-full/get-venda-details/{id}', [ViajesController::class, 'getVendaDetails'])
        ->name('viajes.get-venda-details');
    
    Route::get('/vendas/{id}/edit', [VendasController::class, 'edit'])->name('vendas.editar');
    Route::put('/vendas/{id}', [VendasController::class, 'update'])->name('vendas.update');
    Route::post('/pagamento/store', [PagamentoController::class, 'store'])->name('pagamento.store');
    Route::post('/passengers/store', [PassengerController::class, 'store'])->name('passengers.store');
    Route::get('/passengers/{venda_id}', [PassengerController::class, 'getPassengers'])->name('passengers.get');
    Route::delete('/passengers/{id}', [PassengerController::class, 'destroy'])->name('passengers.delete');
    Route::get('/email/enviar/{id}', [EmailController::class, 'enviarEmail'])->name('email.enviar');

    Route::get('/viajes-vendedor', [ViajesController::class, 'listarViagens'])->name('viajes.vendedor');
    Route::get('/voucher/{id}/pdf', [EmailController::class, 'gerarVoucherPDF'])->name('voucher.pdf');
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

Route::get('/voucher-login', [VoucherLoginController::class, 'showLogin'])->name('voucher.login');
Route::post('/voucher-login', [VoucherLoginController::class, 'doLogin'])->name('voucher.login.submit');

// Rota protegida por "autenticação de voucher"
Route::middleware('voucher.auth')->group(function () {
    Route::get('/viajes-full/get-venda-details/{id}', [VoucherLoginController::class, 'showVenda'])->name('voucher.show');
});

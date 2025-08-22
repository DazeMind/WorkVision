<?php

use App\Http\Controllers\ConsumerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Finance\FinanceController;
use App\Http\Controllers\Maintainer\CategoryController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\Bank\BankDataController;
use App\Http\Controllers\Web\Client\ClientController;
use App\Http\Controllers\Web\Company\CompanyController;
use App\Http\Controllers\Web\Cuentas\GestorCuentasController;
use App\Http\Controllers\Web\Cuentas\WalletController;
use App\Http\Controllers\Web\Inventaries\InventariesController;
use App\Http\Controllers\Web\OrdersSales\OrdersSalesController;
use App\Http\Controllers\Web\OrdersSales\ProductsController;
use App\Http\Controllers\Web\Proyect\AttendanceController;
use App\Http\Controllers\Web\Proyect\ProyectController;
use App\Http\Controllers\Web\Proyect\TaskController;
use App\Http\Controllers\Web\Proyect\WorkerProjectController;
use App\Http\Controllers\Web\Worker\WorkerController;

Route::middleware('guest')->get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('worker', WorkerController ::class)->except(['index']);
    
    Route::get('worker', function () {
        return to_route('worker.create');
    })->name('worker.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('proyect', ProyectController ::class);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('attendances', AttendanceController ::class);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('worker_project', WorkerProjectController ::class);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('tasks', TaskController ::class);
    Route::put('tasks/updateState/{task}', [TaskController::class, 'updateState'])->name('tasks.updateState');
    Route::post('tasks/complete/{id}', [TaskController::class, 'tasksComplete'])->name('task.complete');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('consumers', ConsumerController ::class);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('products', ProductsController ::class);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('client', ClientController ::class)->except(['client.create']);
});

Route::get('/client/create', [ClientController::class, 'create'])->middleware(['auth'])->name('client.create');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('company', CompanyController ::class);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('BankData', BankDataController ::class);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('category', CategoryController ::class);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified','auth.role:Dashboard.index'])->group(function () {
    Route::resource('cuentas', GestorCuentasController::class)->except(['index']);
    Route::get('cuentas', [GestorCuentasController::class, 'index'])->name('Cuentas');
});

Route::middleware(['auth', 'verified','auth.role:Dashboard.index'])->group(function () {
    Route::resource('ordenes-y-ventas', OrdersSalesController::class)->except(['index']);
    Route::get('ordenes-y-ventas', [OrdersSalesController::class, 'index'])->name('OrdersSales');
    Route::put('ordenes-y-ventas/{id}/estado/{state}', [OrdersSalesController::class, 'editOrderState'])->name('ordenes-y-ventas.editOrderState');
});

Route::middleware(['auth', 'verified','auth.role:Dashboard.index'])->group(function () {
    Route::resource('inventarios', InventariesController::class)->except(['index']);
    Route::get('inventarios', [InventariesController::class, 'index'])->name('inventarios');
    Route::get('inventarios/stock', [InventariesController::class, 'stock'])->name('inventarios.stock');
});

Route::middleware(['auth', 'verified','auth.role:Dashboard.index'])->group(function () {
    Route::resource('products', ProductsController::class)->except(['index']);
    Route::get('products', [ProductsController::class, 'index'])->name('products');
});

Route::middleware(['auth', 'verified','auth.role:Dashboard.index'])->group(function () {
    Route::resource('finance', FinanceController::class)->except(['index']);
    Route::get('DownloadFilteredRecordsExcel', [FinanceController::class, 'DownloadFilteredRecordsExcel']);
    Route::post('incomeExpense/store', [FinanceController::class,'incomeExpenseStore'])->name('incomeExpense.store');
    Route::delete('/program-records/{id}', [FinanceController::class, 'destroyProgramRecord'])->name('programRecords.destroy');
    Route::post('/program-records/{id}', [FinanceController::class, 'updateProgramRecord'])->name('programRecords.update');
});

Route::middleware(['auth', 'verified','auth.role:Dashboard.index'])->group(function () {
    Route::resource('wallet', WalletController::class)->except(['index']);
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/components/buttons', function () {
    return Inertia::render('Components/Buttons');
})->middleware(['auth', 'verified'])->name('components.buttons');
   

require __DIR__ . '/auth.php';

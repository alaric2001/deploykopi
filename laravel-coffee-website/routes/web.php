<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GatewayController;

use App\Http\Controllers\KopiController;
use App\Http\Controllers\RasaKopiController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TransaksiAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentMethodController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', [GatewayController::class, 'door']);


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-dashboard', [KopiController::class, 'dashboard']);
    Route::get('/admin-datakopi', [KopiController::class, 'datakopiadmin']);
    Route::post('/add_kopi', [KopiController::class, 'tambah']);
    Route::put('/update_kopi/{id}', [KopiController::class, 'update']);
    Route::delete('/delete_kopi/{id}', [KopiController::class, 'hapus']);
    
    // Route::get('/admin-datakopi-add', function () {
    //     return view('admin/datakopi/add');
    // });
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/admin-listrasakopi', [RasaKopiController::class, 'index']);
    // Route::get('/admin-addrasakopi', function () {
    //     return view('admin/rasakopi/add_rasa');
    // });
    Route::get('/order-list', [TransaksiAdminController::class, 'orderlist_admin']);
    Route::get('/data-order-admin', [TransaksiAdminController::class, 'data_order_admin']);
    Route::get('/order-detail/{id}', [TransaksiAdminController::class, 'detail']);
    Route::post('/delivered/{id}', [TransaksiAdminController::class, 'delivered']);
    Route::get('/undeliver/count', [TransaksiAdminController::class, 'count_undelivered']);

    Route::post('/add-rasakopi', [RasaKopiController::class, 'add']);
    Route::put('/edit-rasakopi/{id}', [RasaKopiController::class, 'update']);
    Route::delete('/delete_rasa/{id}', [RasaKopiController::class, 'destroy']);

    Route::get('/payment_method', [PaymentMethodController::class, 'index']);
    Route::post('/add-payment_method', [PaymentMethodController::class, 'tambah']);
    Route::put('/edit-payment_method/{id}', [PaymentMethodController::class, 'update']);
    Route::delete('/delete_metode/{id}', [PaymentMethodController::class, 'destroy']);
});

// Route::middleware('auth')->group(function () {
Route::middleware(['auth','user'])->group(function () {
    Route::get('/cart', [CartController::class, 'index_cart']);
    Route::post('/add_cart', [CartController::class, 'add_cart']);
    Route::get('/cart/count', [CartController::class, 'getCartCount']);
    Route::get('/delete_cart/{id}', [CartController::class, 'destroy']);
    Route::post('/add_order', [TransaksiController::class, 'add_order']);
    Route::post('/addOrder_deletedItem', [TransaksiController::class, 'addOrder_deletedItem']);
    Route::post('/cart_order', [TransaksiController::class, 'cart_order']);
    Route::get('/checkout', [TransaksiController::class, 'index']);
    Route::post('/checkout_order', [TransaksiController::class, 'checkout_order']);



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/edit-pp', [ProfileController::class, 'edit_pp']);
});

require __DIR__.'/auth.php';


// Route::get('/index', [KopiController::class, 'index']);
Route::get('/', [KopiController::class, 'index']);
Route::get('/kopi/{id}', [KopiController::class, 'detail']);

// //ADMIN
// Route::get('/admin-dashboard', [KopiController::class, 'dashboard']);
// Route::get('/admin-datakopi', [KopiController::class, 'datakopiadmin']);
// Route::get('/admin-datakopi-add', function () {
//     return view('admin/datakopi/add');
// });
// Route::get('/admin-keuangan', function () {
//     return view('admin/keuangan/index');
// });
// Route::get('/admin-listrasakopi', [RasaKopiController::class, 'index']);
// Route::get('/admin-addrasakopi', function () {
//     return view('admin/rasakopi/add_rasa');
// });

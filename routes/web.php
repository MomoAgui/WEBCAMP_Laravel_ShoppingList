<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\CompletedShoppingListController;

use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\admin\AdminHomeController;
use App\Http\Controllers\admin\AdminUserController;


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

//非ログイン画面
Route::get('/', [AuthController::class, 'index'])->name('front.index');
Route::post('/login', [AuthController::class, 'login']);


//会員登録
Route::get('/user/register',[UserController::class,'index']);
Route::post('/user/register',[UserController::class,'register']);

// 認可処理
Route::middleware(['auth'])->group(function () {
    Route::prefix('/shopping_list')->group(function () {
    Route::get('/list', [ShoppingListController::class, 'list']);
    Route::post('/list',[ShoppingListController::class,'register']);
    Route::delete('/delete/{shopping_list_id}', [ShoppingListController::class, 'delete'])->whereNumber('shopping_list_id')->name('delete');
    Route::post('/complete/{shopping_list_id}', [ShoppingListController::class, 'complete'])->whereNumber('shopping_list_id')->name('complete');
});
    //購入済み「買うもの」一覧
    Route::get('/completed_shopping_list/list',[CompletedShoppingListController::class,'list']);
    Route::get('/logout', [AuthController::class, 'logout']);
});


// 管理画面
Route::prefix('/admin')->group(function () {
    Route::get('', [AdminAuthController::class,'index'])->name('admin.index');
    Route::post('/login', [AdminAuthController::class,'login'])->name('admin.login');
    
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/top', [AdminHomeController::class, 'top'])->name('admin.top');
        Route::get('/user/list', [AdminUserController::class, 'list'])->name('admin.user.list');
    });
    Route::get('/logout', [AdminAuthController::class, 'logout']);
});



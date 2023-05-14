<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShoppingListController;


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
Route::post('/shopping_list/list', [AuthController::class, 'login']);


//会員登録
Route::get('/user/register',[UserController::class,'index']);
Route::post('/user/register',[UserController::class,'register']);

// 認可処理
Route::middleware(['auth'])->group(function () {
        Route::get('/shopping_list/list', [ShoppingListController::class, 'list']);
    　　Route::post('/shopping_list/register',[ShoppingListController::class,'register']);
    //
    Route::get('/completed_tasks/list',[CompletedTaskController::class,'list'])->name('completed_list');
    Route::get('/logout', [AuthController::class, 'logout']);
});


// 管理画面
Route::prefix('/admin')->group(function () {
    Route::get('', [AdminAuthController::class, 'index'])->name('admin.index');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/top', [AdminHomeController::class, 'top'])->name('admin.top');
        Route::get('/user/list', [AdminUserController::class, 'list'])->name('admin.user.list');
    });
    Route::get('/logout', [AdminAuthController::class, 'logout']);
});



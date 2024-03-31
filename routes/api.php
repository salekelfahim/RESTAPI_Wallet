<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::get('wallets',[WalletController::class,'getUserWallets'])->middleware('auth:sanctum');
Route::post('addwallet',[WalletController::class,'CreateWallet'])->middleware('auth:sanctum');

Route::post('addbalance',[WalletController::class,'AddBalance'])->middleware('auth:sanctum');

Route::post('sendbalance',[TransactionController::class,'sendBalance'])->middleware('auth:sanctum');
Route::get('transactions',[TransactionController::class,'getTransactions'])->middleware('auth:sanctum');




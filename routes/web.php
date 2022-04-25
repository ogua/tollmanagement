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
    
    return Redirect()->to('admin');
});


Route::get('/register', [App\Http\Controllers\RegisterController::class, 'register']);


Route::post('/user-register/save', [App\Http\Controllers\RegisterController::class, 'saveform']);



// Route::get('/admin', function () {
    
//     //return Redirect()->to('/admin/auth/login');

// })->name('login');

// Route::post('/pay', [
//         'uses' => 'PaymentController@redirectToGateway',
//         'as' => 'pay'
//     ]);

// Route::get('/payment/callback', 'PaymentController@handleGatewayCallback');

// Route::get('/paystack/all-transactions/student', [
//         'uses' => 'PaymentController@getAlltransactions_student',
//         'as' => 'paystack-all-transactions-student'
//     ]);

// Route::get('/paystack/transaction-details/{refid}', [
//         'uses' => 'PaymentController@transaction_refid',
//         'as' => 'transaction_refid'
//     ]);

// Route::get('/paystack/all-transactions', [
//         'uses' => 'PaymentController@getAlltransactions',
//         'as' => 'paystack-all-transactions'
//     ]);

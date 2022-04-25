<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resources([
        'tollpoints'     =>  Tollpoint\TollpointController::class,
        'tolllanes'      =>  Tollpoint\TolllanesController::class,
        'userprofiles'   =>  Userprofile\UserprofileController::class,
        'vehicles'       =>  Vehicles\VehiclesController::class,
        'paystackmodels' =>  Paystackmodel\PaystackmodelController::class,
        'paystackmodel' =>   Paystackmodel\PaystacktrController::class,
        'receivetrans'  =>   Accounts\ReceivetranController::class,
        'allreceivetrans'  =>   Accounts\AdmintransController::class







    ]);


 $router->get('profile', 'Userprofile\ProfileController@getprofileSetting');
 $router->put('user-profiles/update','Userprofile\ProfileController@updateform');
 $router->post('user-profiles/save','Userprofile\ProfileController@saveform');


 $router->get('makepayment', 'PaymentController@makepayment');
 $router->post('pay', 'PaymentController@redirectToGateway');
 $router->get('payment/callback', 'PaymentController@handleGatewayCallback');

 
//  $router->get('all-transactions', 'Paystackmodel\PaystackmodelController@alltransactions');

//  $router->get('paystack/all-transactions', 'PaymentController@getAlltransactions_student');
// $router->get('paystack/transaction-details/{refid}', 'PaymentController@transaction_refid');
//  $router->get('paystack/all-transactions', 'PaymentController@getAlltransactions');






 $router->get('tollrecord', 'PaymentController@tollrecord');


 $router->post('user-register/save','Userprofile\ProfileController@registeruser');

});


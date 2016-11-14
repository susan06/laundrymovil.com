<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

    Route::get('/home', 'HomeController@index');

    /**
     * Setting of system
    */
    Route::group([
         'prefix' => 'setting'
     ], function () {

        Route::get('/administration',
            'SettingController@administration')
            ->name('setting.administration');

     	Route::get('/conditions_and_privacy',
     		'SettingController@conditions_and_privacy')
    		->name('setting.conditions_and_privacy');

        Route::post('/update',
            'SettingController@update')
            ->name('setting.update');

     });

    /**
     * Adminitrations of Users
    */
    Route::get('user/clients', 'UserController@client_index')->name('admin.client.index');
    Route::get('user/drivers', 'UserController@driver_index')->name('admin.driver.index');
    Route::resource('user', 'UserController');

    /**
     *  Adminitrations of Roles
    */
    Route::resource('role', 'RoleController');

    /**
     * Coupons
    */
    Route::resource('coupon', 'CouponController');

    /**
     * Coupons
    */
    Route::resource('branch-office', 'branchOfficeController');
     
    /**
     * Clients
    */
    Route::resource('clients', 'ClientsController');

    /**
     * Driver
    */
    Route::resource('driver', 'DriverController');

    /**
     * Faqs
    */
    Route::resource('faq', 'FaqController');

    /**
     * Request Services
    */
    Route::get('services', [
        'as' => 'clients.services',
        'uses' => 'ClientsController@requestServices'
    ]);

    /**
     * Terms and Conditions
    */
    Route::get('terms', [
        'as' => 'clients.terms',
        'uses' => 'ClientsController@termsAndConditions'
    ]);

    /**
     * Orders
    */
    Route::get('orders', [
        'as' => 'clients.orders',
        'uses' => 'ClientsController@myOrders'
    ]);

    /**
     * My Profile
    */
    Route::get('profile', [
        'as' => 'clients.profile',
        'uses' => 'ClientsController@myProfile'
    ]);

    /**
     * Frequent Questions
    */
    Route::get('questions', [
        'as' => 'clients.questions',
        'uses' => 'ClientsController@frequentQuestions'
    ]);

    /**
     * Privacy Policies
    */
    Route::get('privacy', [
        'as' => 'clients.privacy',
        'uses' => 'ClientsController@privacyPolicies'
    ]);

    /**
     * Invit a Friend
    */
    Route::get('invite', [
        'as' => 'clients.invite',
        'uses' => 'ClientsController@inviteFriend'
    ]);

    /**
     * My Itinerary
    */
    Route::get('itinerary', [
        'as' => 'driver.itinerary',
        'uses' => 'DriverController@myItinerary'
    ]);

    /**
     * See Order - Driver
    */
    Route::get('order', [
        'as' => 'driver.order',
        'uses' => 'DriverController@seeOrder'
    ]);

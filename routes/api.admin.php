<?php

// ToDo - fixmi add routes group
// ToDo - Please REFACTOR controllers and add API Trait =)

Route::middleware(['auth'])->group(function () {
    Route::post('/admin/login', 'Admin\Auth\LoginController@login')->name('admin.login');
//     Route::get('profile', 'Admin\ProfileController@profile')->name('profile');
//     Route::get('sysinfo', 'Admin\AdminController@systemInfo')->name('sys.info');
    
//     Route::prefix('clients')->group(function() {
//         Route::get('{type}', 'Admin\ClientsController@index')->where('type', 'buyer|seller')->name('clients.index')->middleware('permission:clients.show');
//         Route::post('store', 'Admin\ClientsController@store')->name('clients.store')->middleware('permission:clients.create');
//         Route::get('{id}', 'Admin\ClientsController@show')->name('clients.show')->middleware('permission:clients.view');
//         Route::patch('{id}', 'Admin\ClientsController@update')->name('clients.update')->middleware('permission:clients.edit');
//         Route::delete('{id}', 'Admin\ClientsController@delete')->name('clients.delete')->middleware('permission:clients.delete');
//         Route::post('moderate/{id}', 'Admin\ClientsController@moderate')->name('clients.moderate')->middleware('permission:clients.edit');

//         Route::post('/update/balance', 'Admin\ClientsController@updateBalance')->name('users.delete')->middleware('permission:users.delete');

// //        добавлены роуты
//         Route::post('store/user', 'Admin\ClientsController@storeUserClient')->name('clients.store.user')->middleware('permission:clients.create');
//         Route::get('get/user', 'Admin\ClientsController@getAllClients')->name('clients.store.user')->middleware('permission:clients.view');
//         Route::get('edit/user/{id}', 'Admin\ClientsController@getClient')->name('clients.store.user')->middleware('permission:clients.view');
//         Route::post('update/user/{id}', 'Admin\ClientsController@updateUserClient')->name('clients.store.user')->middleware('permission:clients.edit');
//         Route::post('banned/user/{id}', 'Admin\ClientsController@bannedClientUser')->name('clients.store.user')->middleware('permission:clients.edit');

//         Route::post('score/create', 'Admin\ClientsController@generateScore')->name('clients.score.create')->middleware('permission:clients.edit');

//         Route::post('generate/user/password', 'Admin\ClientsController@generatePassword')->name('clients.password.generate')->middleware('permission:clients.edit');
//         Route::post('score/send', 'Admin\ClientsController@scoreSend')->name('clients.score.send')->middleware('permission:clients.edit');
// //--------------------

//         Route::delete('office/{id}', 'Admin\ClientsController@deleteOffice')->name('clients.office.delete')->middleware('permission:clients.edit');
//         Route::delete('store/{id}', 'Admin\ClientsController@deleteStore')->name('clients.store.delete')->middleware('permission:clients.edit');
//     });

//     Route::prefix('users')->group(function() {
//         Route::get('clients', 'Admin\UsersController@clients')->name('users')->middleware('permission:users.show');

//         Route::get('', 'Admin\UsersController@index')->name('users')->middleware('permission:users.show');
//         Route::post('store', 'Admin\UsersController@store')->name('users.store')->middleware('permission:users.create');
//         Route::get('{id}', 'Admin\UsersController@show')->name('users.show')->middleware('permission:users.show');
//         Route::patch('{id}', 'Admin\UsersController@update')->name('users.update')->middleware('permission:users.edit');
//         Route::delete('{id}', 'Admin\UsersController@delete')->name('users.delete')->middleware('permission:users.delete');

//         Route::post('/create/ticket/{id}', 'Admin\UsersController@sendMantisTicket')->name('users.ticket.create')->middleware('permission:users.delete');
//     });

 
});


Route::any('/{any?}', function() {
    throw new \App\Exceptions\NotFoundException();
})->where('any', '.*')->name('api.notfound');
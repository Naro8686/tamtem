<?php

Route::group(['prefix' => '/'], function(){
    
    // регистрация
    Route::post('register', 'Client\Auth\RegisterController@register')->name('register');
    Route::get('register/{token}', 'Client\Auth\RegisterController@registerConfirm')->name('register.confirm')->middleware('web');
    // повторить письмо с высылкой о регистрации
    Route::post('/repeateregistermail', 'Client\Auth\RegisterController@repeateRegisterMailSend')->name('repeate.register.send');


    // логин
    Route::post('login', 'Client\Auth\LoginController@login')->name('login');

    // логаут
    Route::post('logout', 'Client\Auth\LogoutController@logout')->name('logout')->middleware('auth:api');

    // сброс пароля
    Route::post('passwordreset', 'Client\Auth\ResetPasswordController@reset')->name('password.reset');
    Route::get('passwordreset/{token}', 'Client\Auth\ResetPasswordController@passwordResetConfirm')->name('password.reset.confirm'); 

    // изменение пароля
    Route::post('passwordchange', 'Client\Auth\ChangePasswordController@changePassword')->middleware('auth:api')->name('password.change');
  
    // Route::get('', function () {
    //     return view('welcome');
    // });
});

// ПОЛЬЗОВАТЕЛИ
Route::group(['middleware' => ['auth:api'], 'prefix' => '/users', 'as' => 'users.'], function(){

    Route::get('', 'Client\UserController@index')->middleware('only_admin')->name('index');
    Route::get('{id}', 'Client\UserController@get')->name('show');
    Route::post('store', 'Client\UserController@create')->middleware('only_admin')->name('store');
    Route::post('{id}', 'Client\UserController@update')->name('update');
    Route::delete('{id}', 'Client\UserController@delete')->middleware('only_admin')->name('delete');
    Route::delete('/restore/{id}', 'Client\UserController@restore')->middleware('only_admin')->name('restore');
    Route::post('/image/delete', 'Client\UserController@deleteImage')->name('delete.image');
});

// ОРГАНИЗАЦИИ (портфель компаний)
Route::group(['middleware' => ['auth:api'], 'prefix' => '/organizations', 'as' => 'organizations.'], function(){

    Route::get('', 'Client\OrganizationController@index')->name('index');
    Route::get('{id}', 'Client\OrganizationController@get')->name('show');   
    Route::post('store', 'Client\OrganizationController@create')->middleware('only_admin')->name('store');
    Route::post('{id}', 'Client\OrganizationController@update')->middleware('only_admin')->name('update');
    Route::delete('{id}', 'Client\OrganizationController@delete')->middleware('only_admin')->name('delete');
    Route::delete('/restore/{id}', 'Client\OrganizationController@restore')->middleware('only_admin')->name('restore');
});

// КЛИЕНТ САЙТА
Route::group(['middleware' => ['auth:api'], 'prefix' => '/user', 'as' => 'client.'], function(){

    Route::get('profile', 'Client\ClientController@getProfile')->name('get-profile'); // получить свой профиль по токену
    Route::post('innisavailable', 'Client\ClientController@innIsAvailable')->name('inn-is-available'); // проверить инн, доступен ли для генерации ссылки
    Route::post('refgenerate', 'Client\ClientController@refGenerate')->name('ref-generate'); // проверить инн, доступен ли для генерации ссылки

    Route::post('refgenerateforme', 'Client\ClientController@refGenerateForMe')->name('ref-generate-for-me');  // генерация рефералки и сохраненеи ее для текущего юзера
});

// ЗАПРОСЫ С СЕРВЕРА ТАМТЕМ
Route::group(['prefix' => '/tamtem', 'as' => 'tamtem.'], function(){

		Route::post('agentidfrominn', 'TamtemAPI\TamtemAPIController@agentIdFromInn')->name('agent-id-from-inn'); // получить id агента по ИНН компании
		Route::post('agentidfrominnn', 'TamtemAPI\TamtemAPIControllerCheck@agentIdFromInn')->name('agent-id-from-innn'); // получить id агента по ИНН компании
});

// ПРОВЕРКА ГИПОТЕЗЫ О СДЕЛКАХ И КОНТАКТАХ ОРГАНИЗАЦИЙ С ТАМТЕМА
Route::group(['middleware' => ['auth:api'], 'prefix' => '/hypothesis', 'as' => 'hypothesis.'], function(){

    Route::get('deals', 'TamtemAPI\TamtemDealController@index')->name('get-deals');  // получить все сделки с кол-вом прикрепленных организаций
    Route::get('deals/{id}', 'TamtemAPI\TamtemDealController@get')->name('get-deal-from-id'); // получить сделку по ее id
    Route::get('organizations/deal/{id}', 'TamtemAPI\TamtemOrganizationController@getFromDealId')->name('get-organizations-from-geal-id');  // получить прикрепленные к агенту организации по id сделки
    Route::post('organizations/attach', 'TamtemAPI\TamtemOrganizationController@attach')->name('set-agent_id_to_organizations-from-geal-id');  // приврепить организации к агенту по id сделки
});


Route::post('getstatistictest', 'ScheduleController@runGetStatisticFromTamtem')->name('getstatistictest');


// инициируем выплату на карту
Route::post('yandex/initialpayouttocard', 'YandexPayout\YandexPayoutController@initialPayoutToCard')->middleware('auth:api')->name('web.payout-to-card');
Route::get('yandex/successbankcarddata/{unique_id}/{amount}', 'YandexPayout\YandexPayoutController@successBankCardData')->name('web.success-bank-card-data');
// инициируем выплату на мобильник
Route::post('yandex/initialpayouttomobilephone', 'YandexPayout\YandexPayoutController@initialPayoutToMobilePhone')->middleware('auth:api')->name('web.payout-to-phone');

// Api 404
Route::any('/{any?}', function() {
    throw new \App\Exceptions\NotFoundException();
})->where('any', '.*')->name('api.v1.notfound');

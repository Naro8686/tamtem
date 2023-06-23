<?php

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

Route::get('test', 'Client\ClientController@test')->name('test');

Route::get('yandex/error', 'YandexPayout\YandexPayoutController@error')->name('web.error-bank-card-data');

Route::group(['prefix' => '/', 'as' => 'web.'], function(){
    /* faq
    Route::get('{FAQ}', function(){
        return view('faq');
		})->name('faq')->where('FAQ', 'faq|FAQ');
		*/
		Route::get('faq', function(){return view('faq');})->name('faq.page');
		Route::get('about', function(){return view('about');})->name('faq.page');

    // переход по реферальной ссылка для регистрации
    Route::get('/ref/{data}', 'Client\Auth\RegisterController@referalLinkEnter')->name('referal-url-enter');
});

Route::group(['prefix' => '/{any?}', 'as' => 'web.'], function(){
    Route::get('', 'Client\ClientController@index')->where('any', '.*')->name('index');
});


// Route::any('/{any?}', function() {
//     throw new \App\Exceptions\NotFoundException();
// })->where('any', '.*')->name('web.notfound');
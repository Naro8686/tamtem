<?php

namespace App\Classes\YandexMoney;

use App\Classes\YandexMoney\Settings;

use App\Traits\ApiControllerTrait;

class TestYandexPayout
{

    use ApiControllerTrait;

    public function run(){

        $settings               = new \App\Classes\YandexMoney\Settings(Settings::ENV_TEST);

        // $settings->host         = $params['yandexPayout']['host'];
        // $settings->cert         = $params['yandexPayout']['cert'];
        // $settings->certPassword = $params['yandexPayout']['certPassword'];
        // $settings->privateKey   = $params['yandexPayout']['privateKey'];
        // $settings->yaCert       = $params['yandexPayout']['yaCert'];
        $provider               = new \App\Classes\YandexMoney\PKCS7RequestProvider($settings);

        $api = new \App\Classes\YandexMoney\PayoutAPI($provider,  $settings->synonimUrl);
        
        $clientOrderId = \App\Classes\YandexMoney\Helpers\UUID::v4();// \App\Classes\YandexMoney\DepositionRequestParams::generateUniqueClientOrderId('card'); // генерим уникальный id операции

        // Обработка перевода
        $depositionParams             = new \App\Classes\YandexMoney\DepositionRequestParams($settings->ageniId, $clientOrderId, 'makeDeposition');

        $depositionParams->amount     = 150;
       // $depositionParams->dstAccount = "25700120202056919";
        $cardNumber = "4817760139628725";  // моя
        $depositionParams->currency   = "643";
        $depositionParams->contract   = '';

        $depositionType = Settings::DEPOSITION_TYPE_BANK_CARD;

        if ($depositionType == Settings::DEPOSITION_TYPE_MOBILE) {
            $paymentParams               = new \App\Classes\YandexMoney\MobilePaymentParams();
            $paymentParams->operatorCode = $phoneOperatorCode;
            $paymentParams->phoneNumber  = $phoneNumber;

            $depositionParams->setPaymentParams($paymentParams);
            $depositionParams->dstAccount = ($settings->typeEnv === Settings::ENV_TEST) ? $paymentParams->phoneNumber : $paymentParams->phoneNumber;
        
        } elseif ($depositionType == Settings::DEPOSITION_TYPE_BANK_CARD) {

     
           return \redirect($urlToCardData);
           
            // Получаем синоним и маску
            $synonimRes = $api->getCardSynonim($cardNumber);
            // dd($synonimRes );  
            if ($synonimRes != null and \is_array($synonimRes)) {

                if(isset($synonimRes['reason'])){
                    if($synonimRes['reason'] === "success"){
                        $cardSynonim = $synonimRes['skr_destinationCardSynonim']; // Синоним номера банковской карты
                        $cardMask    = $synonimRes['skr_destinationCardPanmask'];
                    }
                    else{
                        // if($synonimRes['reason'] === "cardinvalid"){
                        return $this->errorResponse( $synonimRes['reason']);
                    }
                }
                else{
                    return $this->errorResponse( "bad card get synonim");
                }

            }
            else{
                return $this->errorResponse( $synonimRes);
            }
       //    dd($synonimRes );   
            $paymentParams              = new \App\Classes\YandexMoney\BankCardPaymentParams();
            $paymentParams->cardSynonim = $cardSynonim;
        
            $paymentParams->lastName   = "Иванов"; // string(50) Фамилия
            $paymentParams->firstName  = "Иван"; // string(50) Имя
            $paymentParams->middleName = "Иванович"; // string(50) Отчество. Обязательно, если есть в паспорте
            $paymentParams->docNumber   = 1234567890; // long(10)  - серия и номер паспорта без пробелов
        
            $paymentParams->birthDate  = "01.01.1940"; // string(10) Дата рождения в формате ДД.ММ.ГГГГ
            $paymentParams->birthPlace = "гор.Ленинград";
            $paymentParams->address    = "3-я улица Строителей, д. 25"; // string(30) Город получателя платежа
            $paymentParams->city       = "Санкт-Петербург"; // string(100) Адрес получателя платежа
            $paymentParams->country    = 643; // int(3) ражданство. Указывается как цифровой код страны (РФ — 643)
            $paymentParams->postcode   = 194044; // long (6) Почтовый индекс
        

           // $paymentParams->docIssueYear    = 1999; // long(4) Год выдачи паспорта 
            //$paymentParams->docIssueMonth   = 07; // long(2) Месяц выдачи паспорта 
            //$paymentParams->docIssueDay     = 30; // long(2) День (число месяца) выдачи паспорта 
            $paymentParams->docIssueDate   = "30.07.1999"; // string(10) Дата выдачи паспорта в формате ДД.ММ.ГГГГ
            $paymentParams->docIssuedBy    = "ТП №20 по СПб и ЛО"; // string() Орган, выдавший паспорт

            $paymentParams->smsPhoneNumber = 79103367096; // long(15) Номер телефона получателя платежа в международном формате (79...)
        
            $depositionParams->setPaymentParams($paymentParams);
            $depositionParams->dstAccount = ($settings->typeEnv === Settings::ENV_TEST) ? Settings::DST_ACCOUNT_BANK_CARD_TEST : Settings::DST_ACCOUNT_BANK_CARD_PRODUCTION;
        } else {
            // Перевод на Яндекс кошелёк, уточненять параметры перевода не требуется
        }
        
      //  $response = $api->makeDeposition($depositionParams);
        $response = $api->makeDeposition($depositionParams);
    dd($response);    
        switch (intval($response['status'])) {
            case \App\Classes\YandexMoney\PayoutAPI::REQ_STATUS_SUCCESS:
                // ...
                break;
            case \App\Classes\YandexMoney\PayoutAPI::REQ_STATUS_IN_PROGRESS:
                // ...
                break;
            case \App\Classes\YandexMoney\PayoutAPI::REQ_STATUS_REJECTED:
                $error = $response['error'];
                return \App\Classes\YandexMoney\PayoutAPI::translateError($error);
                break;
        }
    }
}

<?php

$settings               = new \App\Classes\YandexMoney\Settings();
$settings->host         = $params['yandexPayout']['host'];
$settings->cert         = $params['yandexPayout']['cert'];
$settings->certPassword = $params['yandexPayout']['certPassword'];
$settings->privateKey   = $params['yandexPayout']['privateKey'];
$settings->yaCert       = $params['yandexPayout']['yaCert'];
$provider               = new \App\Classes\YandexMoney\PKCS7RequestProvider($settings);

$api = new \App\Classes\YandexMoney\PayoutAPI($provider, $params['yandexPayout']['cardSynonimUrl']);

$clientOrderId = \App\Classes\YandexMoney\DepositionRequestParams::generateUniqueClientOrderId('card');

// Обработка перевода
$depositionParams             = new \App\Classes\YandexMoney\DepositionRequestParams($agentId, $clientOrderId, 'makeDeposition');
$depositionParams->amount     = $amount;
$depositionParams->dstAccount = $dstAccount;
$depositionParams->currency   = $currency;
$depositionParams->contract   = $contract;

if ($depositionType == TYPE_MOBILE) {
    $paymentParams               = new \App\Classes\YandexMoney\MobilePaymentParams();
    $paymentParams->operatorCode = $phoneOperatorCode;
    $paymentParams->phoneNumber  = $phoneNumber;
    $depositionParams->setPaymentParams($paymentParams);
} elseif ($depositionType == TYPE_BANK_CARD) {
    // Получаем синоним и маску
    $synonimRes = $api->getCardSynonim($cardNumber);
    if ($synonimRes != null) {
        $cardSynonim = $synonimRes['skr_destinationCardSynonim'];
        $cardMask    = $synonimRes['skr_destinationCardPanmask'];
    }
    
    $paymentParams              = new \App\Classes\YandexMoney\BankCardPaymentParams();
    $paymentParams->cardSynonim = $cardSynonim;

    $paymentParams->lastName   = $payerLastName;
    $paymentParams->firstName  = $payerFirstName;
    $paymentParams->middleName = $payerMiddleName;

    $paymentParams->birthDate  = $payerBirthDate;
    $paymentParams->birthPlace = $payerBirthPlace;
    $paymentParams->address    = $payerAddress;
    $paymentParams->city       = $payerCity;
    $paymentParams->country    = $payerCountry;
    $paymentParams->postcode   = $payerPostcode;

    $paymentParams->docNumber      = $payerDocNumber;
    $paymentParams->docIssueDate   = $payerDocIssueDate;
    $paymentParams->docIssuedBy    = $payerDocIssuedBy;
    $paymentParams->smsPhoneNumber = $smsPhoneNumber;

    $depositionParams->setPaymentParams($paymentParams);
} else {
    // Перевод на Яндекс кошелёк, уточненять параметры перевода не требуется
}

$response = $api->makeDeposition($depositionParams);

switch (intval($response['status'])) {
    case \App\Classes\YandexMoney\PayoutAPI::REQ_STATUS_SUCCESS:
        // ...
        break;
    case \App\Classes\YandexMoney\PayoutAPI::REQ_STATUS_IN_PROGRESS:
        // ...
        break;
    case \App\Classes\YandexMoney\PayoutAPI::REQ_STATUS_REJECTED:
        $error = $response['error'];
        // ...
        break;
}

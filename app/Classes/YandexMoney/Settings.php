<?php

namespace App\Classes\YandexMoney;

use PhpParser\Node\Stmt\Case_;

class Settings
{

    public $typeEnv = self::ENV_PRODUCTION; // текущий режим работы сервиса
    const ENV_PRODUCTION    = 1;  // режим тестирования
    const ENV_TEST          = 2; // режим боевой

    public $ageniId;
    const AGENT_ID_PRODUCTION   = 203021;
    const AGENT_ID_TEST         = 500153;

    public $host;
    const HOST_PRODUCTION   = "https://calypso.yamoney.ru:9094";
    const HOST_TEST         = "https://calypso.yamoney.ru:9094/"; // ткой же вроде , как и боевой, в доках ХЗ, хрен найдешь
    //const HOST_TEST         = "https://bo-demo02.yamoney.ru:9094";

    // куда выводить деньги
    public $depositionTo;
    const DEPOSITION_TYPE_BANK_CARD = 1;
    const DEPOSITION_TYPE_MOBILE    = 2;

    // Адрес для получения синонима карты
    const SYNONIM_URL_PRODUCTION = "https://paymentcard.yamoney.ru/gates/card/storeCard";
    const SYNONIM_URL_TEST       = "https://paymentcard.yamoney.ru/gates/card/storeCard"; // пока такой же вроде, как продакшен

    // Идентификатор получателя перевода. Зависит от того, куда вы отправляете перевод:
    // на банковскую карту
    public $dstAccount;
    const DST_ACCOUNT_BANK_CARD_PRODUCTION  = "25700130535186";
    const DST_ACCOUNT_BANK_CARD_TEST        = "25700120202056919";

    //сертификат, которым подписываются ответы на запросы контрагента в рамках протокола выплат
    const CERT_YANDEX_PRODUCTION    =   __DIR__ . DIRECTORY_SEPARATOR . "Certs" . DIRECTORY_SEPARATOR  . "yandex_verify.pem";
    const CERT_YANDEX_TEST          =   __DIR__ . DIRECTORY_SEPARATOR . "Certs" . DIRECTORY_SEPARATOR  . "yandex_verify.pem"; // пока такой же, как и боевой


    public $synonimUrl = "https://paymentcard.yamoney.ru/gates/card/storeCard"; // куда слать запрос на получение синонима карты


   // public $privateKey = "live_vap8Z7aBQMrNk0tTgBVdRx_NEi-uf0tPRO3I5bbQdeo";
    public $privateKey = __DIR__ . DIRECTORY_SEPARATOR . "Certs" . DIRECTORY_SEPARATOR  . "private_key.pem";

    public $cert = __DIR__ . DIRECTORY_SEPARATOR . "Certs" . DIRECTORY_SEPARATOR  . "203021_adp.tamtem.pem";

    // пароль к приватному ключу
    public $certPassword = "89hg!829#3h52";
    
    public $yaCert ;//= __DIR__ . DIRECTORY_SEPARATOR . "Certs" . DIRECTORY_SEPARATOR  . "payouts_responsverify_production.pem";

    // куда редиректить для заполнения данных юзера по карте
    public $urlToError = "/yandex/error"; // при ошибке
    public $urlSuccessBankCardData = "/api/v1/yandex/successbankcarddata"; //  при успехе
    public  $urlToCardData ; //= "https://money.yandex.ru/cardauth/payout?url_error=" . $this->urlToError . "&url_success=" . $this->urlSuccessBankCardData . "&identify=true";

    public function __construct()
    {
       

        if($this->typeEnv === self::ENV_TEST){

            $this->host     = self::HOST_TEST;
            $this->ageniId  = self::AGENT_ID_TEST;
            $this->synonimUrl  = self::SYNONIM_URL_TEST;
            $this->yaCert  = self::CERT_YANDEX_TEST;
            $this->dstAccount  = Settings::DST_ACCOUNT_BANK_CARD_TEST;
        }
        elseif($this->typeEnv === self::ENV_PRODUCTION){

            $this->host     = self::HOST_PRODUCTION;
            $this->ageniId  = self::AGENT_ID_PRODUCTION;
            $this->synonimUrl  = self::SYNONIM_URL_PRODUCTION;
            $this->yaCert  = self::CERT_YANDEX_PRODUCTION;
            $this->dstAccount  = Settings::DST_ACCOUNT_BANK_CARD_PRODUCTION;
        }
        else{
            return null;
        }
    }

    public function setUrlToCardData($amount, $uniqueId){

        $this->urlToCardData = "https://money.yandex.ru/cardauth/payout?url_error=" . url($this->urlToError) . "&url_success=" . url($this->urlSuccessBankCardData) . "/" . $uniqueId . "/" . $amount. "&identify=true";
        // если платеж до 15000 , то можно вводить меньше данных на форме яндекса
        if((double) $amount < 15000){
           $this->urlToCardData .= '&small_amount_only=true'; 
        }
    }
}
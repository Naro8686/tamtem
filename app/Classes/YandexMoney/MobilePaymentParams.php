<?php

namespace App\Classes\YandexMoney;

class MobilePaymentParams extends PaymentParams
{
    public $operatorCode;
    public $phoneNumber;


    public function asXml()
    {
        $result = parent::asXml();

     //   $result->addChild('PROPERTY1', sprintf('%03.d', $this->operatorCode));
     //   $result->addChild('PROPERTY2', sprintf('%07.d', $this->phoneNumber));

        return $result;
    }
}
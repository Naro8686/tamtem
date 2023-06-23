<?php

namespace App\Classes\YandexMoney\interfaces;

use App\Classes\YandexMoney\BalanceRequestParams;
use App\Classes\YandexMoney\DepositionRequestParams;

interface IPayoutAPI
{
    public function makeDeposition(DepositionRequestParams $params);

    public function testDeposition(DepositionRequestParams $params);

    public function getBalance(BalanceRequestParams $params);

    public function errorDepositionNotification($handler);
}

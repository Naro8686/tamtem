<?php

namespace App\Classes\YandexMoney\interfaces;

interface IDispositionRequestProvider
{
    public function sendRequest($dispositionMethod, IXMLTransformable $params);
    public function processRequest($handler);
}

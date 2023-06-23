<?php

namespace App\Classes\YandexMoney\interfaces;

interface IXMLTransformable
{
    public function asXml();
    public function toXml();
}
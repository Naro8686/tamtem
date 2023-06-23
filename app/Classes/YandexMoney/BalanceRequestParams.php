<?php

namespace App\Classes\YandexMoney;

use App\Classes\YandexMoney\interfaces\IXMLTransformable;

class BalanceRequestParams implements IXMLTransformable
{
    private $agentId;
    private $clientOrderId;

    public function __construct($agentId, $clientOrderId)
    {
        $this->agentId       = $agentId;
        $this->clientOrderId = $clientOrderId;
    }

    public function asXml()
    {
        $result = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><balanceRequest/>');

        $result->addAttribute('agentId', $this->agentId);
        $result->addAttribute('clientOrderId', $this->clientOrderId);
        $result->addAttribute('requestDT', date('Y-m-d\TH:i:s.000\Z'));

        return $result;
    }

    public function toXml()
    {
        return $this->asXml()->asXML();
    }
}
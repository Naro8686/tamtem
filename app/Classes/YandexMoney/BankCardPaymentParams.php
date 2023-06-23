<?php

namespace App\Classes\YandexMoney;

class BankCardPaymentParams extends PaymentParams
{

    public $cardSynonim;
    public $accountNumber;

    public $lastName;
    public $firstName;
    public $middleName;

    public $birthDate;
    public $birthPlace;

    public $docNumber;
    public $docIssueDate;
    public $docIssuedBy;
    public $country = 643;
    public $city;
    public $address;
    public $postcode;
    public $smsPhoneNumber;
    
    
    public $docIssueYear;
    public $docIssueMonth;
    public $docIssueDay;



    public function asXml()
    {
        $result = parent::asXml();

        $result->addChild('skr_destinationCardSynonim', $this->cardSynonim);
        $result->addChild('cps_ymAccount', $this->accountNumber);

        // $result->addChild('pdr_lastName', $this->lastName);
        // $result->addChild('pdr_firstName', $this->firstName);
        // $result->addChild('pdr_middleName', $this->middleName);
        // $result->addChild('pdr_docNumber', $this->docNumber);
        // $result->addChild('pdr_docIssueYear', date('Y', strtotime($this->docIssueDate)));
        // $result->addChild('pdr_docIssueMonth', date('m', strtotime($this->docIssueDate)));
        // $result->addChild('pdr_docIssueDay', date('d', strtotime($this->docIssueDate)));
        // $result->addChild('pdr_birthDate', date('d.m.Y', strtotime($this->birthDate)));
        // $result->addChild('pdr_birthPlace', $this->birthPlace);
        // $result->addChild('pdr_docIssuedBy', $this->docIssuedBy);
        // $result->addChild('pdr_country', $this->country);
        // $result->addChild('pdr_city', $this->city);
        // $result->addChild('pdr_address', $this->address);
        // $result->addChild('pdr_postcode', $this->postcode);
        // $result->addChild('smsPhoneNumber', $this->smsPhoneNumber);

        return $result;
    }
}

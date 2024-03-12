<?php

namespace App\Factory;

use App\Dto\CurrencyDto;
use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use Doctrine\ORM\EntityManagerInterface;

class CurrencyFactory
{
    public function create(CurrencyDto $currencyDto): Currency
    {
        $currency = new Currency();

        $currency->setName($currencyDto->name);
        $currency->setCurrencyCode($currencyDto->currencyCode);
        $currency->setExchangeRate($currencyDto->exchangeRate);

        return $currency;
    }
}
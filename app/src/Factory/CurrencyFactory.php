<?php

namespace App\Factory;

use App\Dto\CurrencyDto;
use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use Doctrine\ORM\EntityManagerInterface;

class CurrencyFactory
{
    public function __construct(
        private readonly CurrencyRepository $currencyRepository,
        private readonly EntityManagerInterface $entityManager
    ) {}

    public function create(CurrencyDto $currencyDto): Currency
    {
        $currency = $this->currencyRepository->findOneBy(['currencyCode' => $currencyDto->currencyCode]);

        if (!$currency) {
            $currency = new Currency();

            $currency->setName($currencyDto->name);
            $currency->setCurrencyCode($currencyDto->currencyCode);
        }

        $currency->setExchangeRate($currencyDto->exchangeRate);

        $this->entityManager->persist($currency);
        $this->entityManager->flush();

        return $currency;
    }
}
<?php

namespace App\Dto;

class CurrencyDto
{
    public function __construct(
        public string $name,
        public string $currencyCode,
        public int $exchangeRate,
    ) {}
}
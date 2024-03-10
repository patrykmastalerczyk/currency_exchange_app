<?php

namespace App\Service;

use App\Dto\CurrencyDto;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CurrencyService
{
    public function __construct(
        private readonly HttpClientInterface $httpClient
    ) {}

    private const API_URL = 'https://api.nbp.pl/api/exchangerates/tables/a?format=json';

    public function fetchExchangeRates(): array
    {
        $body = $this->httpClient->request('GET', self::API_URL);
        $content = json_decode($body->getContent(false), associative: true)[0];

        return array_map(function (array $row) {
            return new CurrencyDto(
                $row['currency'],
                $row['code'],
                $row['mid'] * 10000
            );
        }, $content['rates']);
    }
}
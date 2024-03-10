<?php

namespace App\Command;

use App\Dto\CurrencyDto;
use App\Repository\CurrencyRepository;
use App\Service\CurrencyService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchCurrencyDataCommand extends Command
{
    public function __construct(
        private readonly CurrencyRepository $currencyRepository,
        private readonly CurrencyService $currencyService,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $exchangeRates = $this->currencyService->fetchExchangeRates();

        foreach ($exchangeRates as $exchangeRate) {
            $existingRate = $this->currencyRepository->findByName($exchangeRate->name);

            $this->currencyRepository->upsert(
                $existingRate?->getId() ?? Uuid::v4(),
                new CurrencyDto($exchangeRate->name, $exchangeRate->currencyCode, $exchangeRate->exchangeRate)
            );
        }

        return Command::SUCCESS;
    }
}
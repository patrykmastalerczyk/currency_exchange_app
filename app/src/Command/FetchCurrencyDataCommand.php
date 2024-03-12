<?php

namespace App\Command;

use App\Dto\CurrencyDto;
use App\Factory\CurrencyFactory;
use App\Repository\CurrencyRepository;
use App\Service\CurrencyService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Uid\Uuid;

class FetchCurrencyDataCommand extends Command
{
    protected static $defaultName = 'app:fetch-currency-rates';

    public function __construct(
        private readonly CurrencyRepository $currencyRepository,
        private readonly CurrencyService $currencyService,
        private readonly CurrencyFactory $currencyFactory,
        private readonly LoggerInterface $logger
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName(self::$defaultName)->setDescription('Fetch currency exchange rates from an external API.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $exchangeRates = $this->currencyService->fetchExchangeRates();

        $this->logger->alert('Fetching currency exchange rates...');

        foreach ($exchangeRates as $exchangeRate) {
            $entity = $this->currencyFactory->create(new CurrencyDto($exchangeRate->name, $exchangeRate->currencyCode, $exchangeRate->exchangeRate));
            $this->currencyRepository->upsert($entity);

            $this->logger->alert(sprintf('Currency %s updated. Current exchange rate is now: (1 PLN = %f %s)',
                $exchangeRate->currencyCode,
                1 / $exchangeRate->exchangeRate * 10000,
                $exchangeRate->currencyCode,
            ));
        }

        $this->logger->alert(sprintf('Fetched %d exchange rates total.', count($exchangeRates)));

        return Command::SUCCESS;
    }
}
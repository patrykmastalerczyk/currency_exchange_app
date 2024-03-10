
# Symfony exchange rate comparison app
This application retrieves the current exchange rate from an external NBP API and compares it to the Polish Zloty (PLN).

## Features:
- Fetch the current exchange rates from Table A of the external NBP API.
- Display fetched data in the command line.
- Streamlined development and deployment thanks to Docker Compose.

## Getting Started:
### 1. Clone the repository:
```
~/$ git clone https://github.com/patrykmastalerczyk/currency_exchange_app
~/$ cd currency_exchange_app
```
### 2. Initialize containers:

```
~/$ docker compose up -d
```
### 3. Install dependencies:

```
~/$ docker exec -it php bash
~/container$ composer install
```

<?php
declare(strict_types=1);

namespace App\Model;

use App\Interface\CurrencyExchangeInterface;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

#[When(env: 'dev')]
#[When(env: 'prod')]
final class CurrencyExchange implements CurrencyExchangeInterface
{
    private const API_KEY = 'k4F4cJ3mEO2oQMbUFk3kw5UUQpijBKMK';
    private const HEADER_NAME = 'apikey';
    private const EXCHANGE_HOST = 'https://api.apilayer.com/exchangerates_data/convert?';

    public function __construct(
        private readonly HttpClientInterface $client
    ){
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function exchange(float $amount, string $currencyFrom, string $currencyTo): float
    {
        $response = $this->client->request(
            'GET',
            $this->getUrlWithParams($amount, $currencyFrom, $currencyTo),
            [
                'headers' => [self::HEADER_NAME => self::API_KEY]
            ]
        );

        try {
            $content = $response->toArray();

            if($content['success']) {
                return $content['result'];
            }

            return 0.0;
        } catch (Throwable $e) {
            return 0.0;
        }
    }

    private function getUrlWithParams(float $amount,string $currencyFrom,string $currencyTo): string
    {
        $options = [
            'to' => $currencyTo,
            'from' => $currencyFrom,
            'amount' => $amount
        ];

        return self::EXCHANGE_HOST . http_build_query($options);
    }
}
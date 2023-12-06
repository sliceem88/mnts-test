<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TransactionControllerTest extends WebTestCase
{
    public function dataProvider(): array
    {
        return [
            [
                'id_from' => '',
                'id_to' => 'BLD14KPC6BF',
                'amount' => 12,
                'currency' => 'USD'
            ],
            [
                'id_from' => 'LPV38ZZW8LB',
                'id_to' => '',
                'amount' => 12,
                'currency' => 'USD'
            ],
            [
                'id_from' => 'LPV38ZZW8LB',
                'id_to' => 'BLD14KPC6BF',
                'amount' => '',
                'currency' => 'USD'
            ],
            [
                'id_from' => 'LPV38ZZW8LB',
                'id_to' => 'BLD14KPC6BF',
                'amount' => 12,
                'currency' => ''
            ]
        ];
    }

    public function test_response_make_transaction_route(): void
    {
        $client = static::createClient();

        $client->request('POST', '/make-transaction', [
            'id_from' => 'LPV38ZZW8LB',
            'id_to' => 'BLD14KPC6BF',
            'amount' => 12,
            'currency' => 'USD'
        ]);

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertSame($response['transactionId'], 3);
    }

    /**
     * @dataProvider dataProvider
     */
    public function test_response_make_transaction_route_missing_params($id_from, $id_to, $amount, $currency): void
    {
        $client = static::createClient();
        $client->request('POST', '/make-transaction', [
            'id_from' => $id_from,
            'id_to' => $id_to,
            'amount' => $amount,
            'currency' => $currency
        ]);

        $result = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('message', $result);
        $this->assertStringStartsWith('Error while processing.', $result['message']);
    }
}

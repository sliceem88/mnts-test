<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TransactionHistoryControllerTest extends WebTestCase
{
    public function test_response_transactions_history_route(): void
    {
        $client = static::createClient();

        $client->request('POST', '/transactions-history', ['account_id' => 'MDI75ORX5PX']);
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertCount(2, $response);
        $this->assertSame('EUR', $response[0]['currency_from']);
    }

    public function test_response_transactions_history_route_fails(): void
    {
        $client = static::createClient();

        $client->request('POST', '/transactions-history');

        $result = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('message', $result);
        $this->assertStringStartsWith('Error while processing. Account id is missing or empty', $result['message']);
    }
}

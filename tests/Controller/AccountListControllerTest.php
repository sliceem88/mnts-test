<?php
declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccountListControllerTest extends WebTestCase
{

    public function test_response_account_list_route()
    {
        $client = static::createClient();

        $client->request('POST', '/account-list', ['client_id' => 1]);

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertIsFloat($response['amount']);
        $this->assertSame('MDI75ORX5PX', $response['account_id']);
    }

    public function test_response_account_list_route_missing_id()
    {
        $client = static::createClient();

        $client->request('POST', '/account-list');

        $this->assertStringContainsString('User id is missing or empty', $client->getResponse()->getContent());
    }
}
<?php
namespace Clickstorm\CsTemplates\Tests\Unit\Service;

use bconnect\MailingWork\ApiException;
use bconnect\MailingWork\Client;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class RecipientClientTest extends UnitTestCase
{
    /**
     * Data provider for testMakeRequestReturnsSuccessfulStatus
     */
    public static function apiMethodsAndParamsDataProvider(): array
    {
        return [
            'recipient' => [
                'recipient',
                [5],
            ],
            'recipient2' => [
                'recipient',
                [6],
            ]
        ];
    }

    /**
     * @test
     * test login via curl
     */
    public function testLoginViaCurl()
    {
        $query = http_build_query([
            'username' => 'ing-sn',
            'password' => '!ng3n!eur'
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://login.mailingwork.de/webservice/webservice/json/getLists');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * @test
     * @dataProvider apiMethodsAndParamsDataProvider
     */
    private function testMakeRequestReturnsSuccessStatus($method, $params)
    {
        $client = Client::getClient('ing-sn', '!ng3n!eur');
        try {
            //$listId = $client->api('list')->createList("Api created list");
            $recipient = $client->api($method)->getRecipientById($params[0] ?? 0);
            var_dump($recipient);
            $this->assertNotEmpty($recipient);
        } catch (ApiException $ex) {
            print "Error occurred";
        }
    }
}

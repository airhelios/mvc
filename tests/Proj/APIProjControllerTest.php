<?php

namespace App\Proj;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test cases for class APIProjController.
 */
class APIProjControllerTest extends WebTestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function setUp(): void
    {

        $client = static::createClient();
        $client->request('POST', '/proj/api/reset_game_tables');
        $this->assertResponseRedirects('/proj/api');
        self::ensureKernelShutdown();
    }


    public function testAPIResetTable(): void
    {
        $client = static::createClient();
        $client->request('POST', '/proj/api/reset_game_tables');
        $this->assertResponseRedirects('/proj/api');
    }
    public function testAPICondemned(): void
    {
        $client = static::createClient();
        $client->request('GET', '/proj/api/condemned');
        $this->assertResponseIsSuccessful();
    }

    public function testAPISaved(): void
    {
        $client = static::createClient();
        $client->request('GET', '/proj/api/saved');
        $this->assertResponseIsSuccessful();
    }

    public function testAPILogged(): void
    {
        $client = static::createClient();
        $client->request('GET', '/proj/api/logged');
        $this->assertResponseIsSuccessful();
    }

    public function testAPIHome(): void
    {
        $client = static::createClient();
        $client->request('GET', '/proj/api');
        $this->assertResponseIsSuccessful();
    }

    public function testAPISaveAll(): void
    {
        $client = static::createClient();
        $client->request('POST', '/proj/api/save_all');
        $this->assertResponseRedirects('/proj/api/saved');
    }

    public function testAPIGetStatus(): void
    {
        //Get level
        $client = static::createClient();
        $client->request('GET', '/proj/play');

        //Get key
        $client->request(
            'POST',
            '/proj/check',
            ["xCoord" => 549 / 679, "yCoord" => 550 / 679],
            [],
            ['Content-Type' => 'application/x-www-form-urlencoded']
        );


        //Get heavenly key
        $client->request(
            'POST',
            '/proj/check',
            ["xCoord" => 763 / 1024, "yCoord" => 586 / 1024],
            [],
            ['Content-Type' => 'application/x-www-form-urlencoded']
        );



        $client->request('POST', '/proj/api/get_status');
        $this->assertResponseIsSuccessful();
    }

}

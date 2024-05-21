<?php

namespace App\Proj;

// use PHPUnit\Framework\TestCase;
// use App\Controller\GameController;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// use Symfony\Bundle\FrameworkBundle\Test\WebTestAssertionsTrait;
// use Symfony\Component\HttpFoundation\Response;

/**
 * Test cases for class Dice.
 */
class APIProjControllerTest extends WebTestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */public function setUp(): void
    {
        if (isset($_ENV['FOO'])) {
            $this->markTestSkipped(
                'Scrutinizer CI build'
            );
        }
    }
    public function testAPICondemned(): void
    {
        if (isset($_ENV['SCRUTINIZER'])) {
            $this->markTestSkipped(
                'Scrutinizer CI build'
            );
        }
        $client = static::createClient();
        $client->request('GET', '/proj/api/condemned');
        $this->assertResponseIsSuccessful();
    }

    public function testAPISaved(): void
    {
        if (isset($_ENV['FOO'])) {
            $this->markTestSkipped(
                'Scrutinizer CI build'
            );
        }
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

    public function testAPIResetTable(): void
    {
        $client = static::createClient();
        $client->request('POST', '/proj/api/reset_game_tables');
        $this->assertResponseRedirects('/proj/api');
    }
}

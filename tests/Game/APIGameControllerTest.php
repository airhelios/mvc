<?php

namespace App\Game;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test cases for class Dice.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class APIGameControllerTest extends WebTestCase
{
    public function testAPILibraryAllRoute(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/play');
        $client->request('GET', '/api/game');

        // $this->assertResponseIsSuccessful();
        $this->assertRouteSame("api_game");
    }

}

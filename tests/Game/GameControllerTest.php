<?php

namespace App\Game;

// use PHPUnit\Framework\TestCase;
// use App\Controller\GameController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
// use Symfony\Bundle\FrameworkBundle\Test\WebTestAssertionsTrait;
// use Symfony\Component\HttpFoundation\Response;

/**
 * Test cases for class Dice.
 */
class GameControllerTest extends WebTestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testGameRoute(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game');

        $this->assertResponseIsSuccessful();
        // $this->assertSelectorTextContains('h1', 'Game Page');
    }

    public function testGameDocRoute(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/doc');

        $this->assertResponseIsSuccessful();
        // $this->assertSelectorTextContains('h1', 'Game Page');
    }

    public function testGameRestart(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/restart');

        $this->assertResponseRedirects('/game/play');
    }

    public function testGameHit(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/hit_me');

        $this->assertResponseRedirects('/game/play');
    }

    public function testGamePlay(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/play');

        $this->assertResponseIsSuccessful();
    }

    
    public function testGameStay(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/stay');

        $this->assertResponseIsSuccessful();
    }
}
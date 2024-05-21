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
        $this->assertRouteSame("game");

        // $this->assertResponseIsSuccessful();
        // $this->assertSelectorTextContains('h1', 'Game Page');
    }

    public function testGameDocRoute(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/doc');

        // $this->assertResponseIsSuccessful();
        $this->assertRouteSame("game_docs");
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


    // public function testGameHitSession(): void
    // {

    //     $sessionMock = $this->createMock(SessionInterface::class);
    //             $gameManager = GameManager::gameManagerNew();
    //     // Configure the mock to return specific values
    //     $sessionMock->method('get')
    //                 ->willReturnMap([
    //                     ['game', $gameManager],  // Simulate $session->get('key') returning 'default_value'
    //                 ]);
    //     $client = static::createClient();
    //     $client->getContainer()->set('session', $sessionMock);
    //     $client->request('GET', '/game/hit_me');
    //     $sessionLocale = $client->getRequest()->getSession()->get('game');
    //     // $this->assertEquals(302, $client->getResponse()->getStatusCode());
    //     $this->assertEquals($gameManager, $sessionLocale);
    //     // $client = static::createClient();
    //     // $gameManager = GameManager::gameManagerNew();
    
    //     // $session = $client->getContainer()->get('session');
    //     // $session->start(); // optional because the ->set() method do the start
    //     // $session->set('game', serialize($gameManager)); // the session is started  here if you do not use the ->start() method
    //     // $session->save(); // important if you want to persist the params
    //     // $client->getCookieJar()->set(new Cookie($session->getName(),  $session->getId()));
    //     // // $session = new Session(new MockFileSessionStorage());
    //     // // $session = $this->createMock(SessionInterface::class);

    //     // // $session->set("game",$gameManager);
    //     // // $client->getContainer()->set('session', $session);
    //     // $client->request('GET', '/game/hit_me');

    //     // $sessionLocale = $client->getRequest()->getSession()->get('game');



    //     // $this->assertInstanceOf(GameManager::class, $sessionLocale);
    // }

    public function testGamePlay(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/play');

        // $this->assertResponseIsSuccessful();
        $this->assertRouteSame("game_play");
    }


    public function testGameStay(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/stay');

        $this->assertRouteSame("game_stay");
        // $this->assertResponseIsSuccessful();
    }
}

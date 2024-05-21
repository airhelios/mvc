<?php

namespace App\Proj;

// use PHPUnit\Framework\TestCase;
// use App\Controller\GameController;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;

// use Symfony\Bundle\FrameworkBundle\Test\WebTestAssertionsTrait;
// use Symfony\Component\HttpFoundation\Response;

/**
 * Test cases for class Dice.
 */
class ProjControllerTest extends WebTestCase
{
    public Session $session;
    public function setUp(): void
    {
        $this->session = new Session(new MockFileSessionStorage());
        $this->session->start();

        parent::setUp();
    }
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testProjHome(): void
    {
        $client = static::createClient();
        $client->request('GET', '/proj');
        $this->assertRouteSame("proj_home");
        $this->assertResponseRedirects('/proj/play');
    }

    public function testProjAbout(): void
    {
        $client = static::createClient();
        $client->request('GET', '/proj/about');
        $this->assertRouteSame("proj_about");
        $this->assertResponseIsSuccessful();
    }

    public function testProjDatabase(): void
    {
        $client = static::createClient();
        $client->request('GET', '/proj/about/database');
        $this->assertRouteSame("proj_database");
        $this->assertResponseIsSuccessful();
    }

    public function testProjPlay(): void
    {
        $client = static::createClient();
        $client->request('GET', '/proj/play');
        $this->assertRouteSame("proj_play");
        $this->assertResponseIsSuccessful();
    }

    public function testProjCheck(): void
    {
        $client = static::createClient();
        //Setup session
        $client->request('GET', '/proj/play');

        $client->request('POST', '/proj/check',["xCoord" => 549 / 679, "yCoord" => 550 / 679],
        [],['Content-Type' => 'application/x-www-form-urlencoded']);
        $session = $client->getRequest()->getSession();
        $this->assertEquals(true,$session->get("key"));

        
        $client->request('POST', '/proj/check',["xCoord" => 763 / 1024, "yCoord" => 586 / 1024],
        [],['Content-Type' => 'application/x-www-form-urlencoded']);
        $session = $client->getRequest()->getSession();
        $this->assertEquals(true,$session->get("heavenly_key"));
        $this->assertRouteSame("proj_check");
        // $this->assertResponseIsSuccessful();
        $this->assertResponseRedirects('/proj/play');
    }



    // public function testGameDocRoute(): void
    // {
    //     $client = static::createClient();
    //     $client->request('GET', '/game/doc');

    //     // $this->assertResponseIsSuccessful();
    //     $this->assertRouteSame("game_docs");
    //     // $this->assertSelectorTextContains('h1', 'Game Page');
    // }

    // public function testGameRestart(): void
    // {
    //     $client = static::createClient();
    //     $client->request('GET', '/game/restart');

    //     $this->assertResponseRedirects('/game/play');
    // }

    // public function testGameHit(): void
    // {
    //     $client = static::createClient();
    //     $client->request('GET', '/game/hit_me');

    //     $this->assertResponseRedirects('/game/play');
    // }


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

    // public function testGamePlay(): void
    // {
    //     $client = static::createClient();
    //     $client->request('GET', '/game/play');

    //     // $this->assertResponseIsSuccessful();
    //     $this->assertRouteSame("game_play");
    // }


    // public function testGameStay(): void
    // {
    //     $client = static::createClient();
    //     $client->request('GET', '/game/stay');

    //     $this->assertRouteSame("game_stay");
    //     // $this->assertResponseIsSuccessful();
    // }
}

<?php

namespace App\Controller;

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
    public function testLibraryRoute(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library');

        $this->assertResponseIsSuccessful();
    }

    public function testLibraryCreate(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library/create');

        $this->assertResponseIsSuccessful();
    }

    public function testLibraryUpdate(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library/update/1');

        $this->assertResponseIsSuccessful();
    }

    public function testShowOne(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library/show/1');

        $this->assertResponseIsSuccessful();
    }

    // public function testReset(): void
    // {
    //     $client = static::createClient();
    //     $client->request('GET', '/library/reset');

    //     $this->assertResponseRedirects('/library/show');
    // }

    public function testShowAll(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library/show');
        $client->catchExceptions(false);


        $this->assertResponseIsSuccessful();
    }

    public function testReset(): void
    {
        $client = static::createClient();
        $client->request('POST', '/library/reset');
        // $client->catchExceptions(false);


        $this->assertRouteSame("library_reset");
    }

}

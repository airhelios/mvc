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

        // $this->assertResponseIsSuccessful();
        $this->assertRouteSame("app_book");

    }

    public function testLibraryCreate(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library/create');

        // $this->assertResponseIsSuccessful();
        $this->assertRouteSame("create_book");

    }

    public function testLibraryUpdate(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library/update/1');

        // $this->assertResponseIsSuccessful();
        $this->assertRouteSame("update_book", ["id" => "1"]);

    }

    public function testShowOne(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library/show/1');

        // $this->assertResponseIsSuccessful();
        $this->assertRouteSame("book_by_id", ["id" => "1"]);
    }

    public function testShowAll(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library/show');
        $client->catchExceptions(false);


        // $this->assertResponseIsSuccessful();
        $this->assertRouteSame("book_show_all");
    }

    public function testReset(): void
    {
        $client = static::createClient();
        $client->request('POST', '/library/reset');
        // $client->catchExceptions(false);


        $this->assertRouteSame("library_reset");
    }

}

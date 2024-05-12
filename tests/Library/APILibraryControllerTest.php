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
class APILibraryControllerTest extends WebTestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testAPILibraryAllRoute(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/library/books');

        // $this->assertResponseIsSuccessful();
        $this->assertRouteSame("api_library_all");
    }

    public function testAPILibraryISBN(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/library/isbn/0-3998-4298-5');

        // $this->assertResponseIsSuccessful();
        $this->assertRouteSame("api_library_isbn", ["isbn" => "0-3998-4298-5"]);
    }

}

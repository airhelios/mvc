<?php

namespace App\Dice;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test cases for class Dice.
 */
class APICardControllerTest extends WebTestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testAPIDeck(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/deck');

        // $this->assertResponseIsSuccessful();
        $this->assertRouteSame("api_deck");
    }

    public function testAPIDeckShuffle(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/deck/shuffle');

        // $this->assertResponseIsSuccessful();
        $this->assertRouteSame("api_show_shuffle");
    }

    public function testAPIDeckUnsorted(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/deck/unsorted');
        $this->assertRouteSame("api_show_unsorted");
    }

    public function testAPIDeckDraw(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/deck/draw');
        $this->assertRouteSame("api_draw");
    }

    public function testAPIDeckDrawNum(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/deck/draw/2');
        $this->assertRouteSame("api_draw_num", ["num" => "2"]);
    }
}

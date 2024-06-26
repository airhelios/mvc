<?php

namespace App\Proj;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test cases for class ProjController.
 */
class ProjControllerTest extends WebTestCase
{
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

    public function testProjCheat(): void
    {
        $client = static::createClient();
        $client->request('GET', '/proj/cheat');
        $this->assertRouteSame("proj_cheat");
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


        $client->request(
            'POST',
            '/proj/check',
            ["xCoord" => 549 / 679, "yCoord" => 550 / 679],
            [],
            ['Content-Type' => 'application/x-www-form-urlencoded']
        );
        $session = $client->getRequest()->getSession();
        $this->assertEquals(true, $session->get("key"));
        $this->assertRouteSame("proj_check");
        // $this->assertResponseIsSuccessful();
        $this->assertResponseRedirects('/proj/play');


        $client->request(
            'POST',
            '/proj/check',
            ["xCoord" => 763 / 1024, "yCoord" => 586 / 1024],
            [],
            ['Content-Type' => 'application/x-www-form-urlencoded']
        );
        $session = $client->getRequest()->getSession();
        $this->assertEquals(true, $session->get("heavenly_key"));

        $client->request(
            'POST',
            '/proj/check',
            ["xCoord" => 514 / 1024, "yCoord" => 762 / 1024],
            [],
            ['Content-Type' => 'application/x-www-form-urlencoded']
        );
        $session = $client->getRequest()->getSession();
        $nextLevel = new HatchLevel();
        $this->assertEquals($nextLevel, $session->get("Level"));

        $session = $client->getRequest()->getSession();
        $nextLevel = new HatchLevel();
        $this->assertEquals($nextLevel, $session->get("Level"));

        $client->request(
            'POST',
            '/proj/check',
            ["xCoord" => 0.49, "yCoord" => 0.415],
            [],
            ['Content-Type' => 'application/x-www-form-urlencoded']
        );
        $client->request(
            'POST',
            '/proj/check',
            ["xCoord" => 0.25, "yCoord" => 0.415],
            [],
            ['Content-Type' => 'application/x-www-form-urlencoded']
        );
        $session = $client->getRequest()->getSession();
        $nextLevel = new HellSceneLevel();
        $this->assertEquals($nextLevel, $session->get("Level"));

        $client->request(
            'POST',
            '/proj/check',
            ["xCoord" => 0.25, "yCoord" => 0.415],
            [],
            ['Content-Type' => 'application/x-www-form-urlencoded']
        );
        $this->assertResponseRedirects('/proj/score');

    }

    public function testProjBack(): void
    {
        $client = static::createClient();
        //Setup session
        $client->request('GET', '/proj/play');

        $client->request('POST', '/proj/back');
        $this->assertResponseRedirects('/proj/play');

    }

    public function testProjSaveRoute(): void
    {
        $client = static::createClient();
        $client->request('GET', '/proj/play');
        $client->request(
            'POST',
            '/proj/check',
            ["xCoord" => 549 / 679, "yCoord" => 550 / 679],
            [],
            ['Content-Type' => 'application/x-www-form-urlencoded']
        );



        $client->request(
            'POST',
            '/proj/check',
            ["xCoord" => 763 / 1024, "yCoord" => 586 / 1024],
            [],
            ['Content-Type' => 'application/x-www-form-urlencoded']
        );


        $client->request(
            'POST',
            '/proj/check',
            ["xCoord" => 514 / 1024, "yCoord" => 762 / 1024],
            [],
            ['Content-Type' => 'application/x-www-form-urlencoded']
        );


        $client->request(
            'POST',
            '/proj/check',
            ["xCoord" => 0.49, "yCoord" => 0.415],
            [],
            ['Content-Type' => 'application/x-www-form-urlencoded']
        );
        $client->request(
            'POST',
            '/proj/check',
            ["xCoord" => 0.25, "yCoord" => 0.415],
            [],
            ['Content-Type' => 'application/x-www-form-urlencoded']
        );


        $client->request(
            'POST',
            '/proj/check',
            ["xCoord" => 0.25, "yCoord" => 0.415],
            [],
            ['Content-Type' => 'application/x-www-form-urlencoded']
        );
        //     'Name' => 'Yuri']);
        $crawler = $client->request('GET', '/proj/score');

        // Check if the form exists and then submit the form
        $form = $crawler->selectButton('score_form_Submit')->form([
            'score_form[Name]' => 'Yuri'
        ]);

        // Submit the form
        $client->submit($form);
        $this->assertResponseRedirects('/proj');


    }
}

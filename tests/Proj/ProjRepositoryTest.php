<?php

namespace App\Proj;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManager;


use App\Entity\Saved;
use App\Entity\Condemned;
use App\Entity\IPLogger;

/**
 * Test cases for class ProjRepository.
 */
class ProjRepositoryTest extends KernelTestCase
{
    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }
    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testSearchByNameCondemned(): void
    {
        $person = $this->entityManager
            ->getRepository(Condemned::class)
            ->findOneBy(['Name' => 'Faust'])
        ;

        $this->assertSame(1, $person->getId());
    }

    public function testSearchByNameSaved(): void
    {
        $person = $this->entityManager
            ->getRepository(Saved::class)
            ->findOneBy(['Name' => 'Herman'])
        ;
        $this->assertSame(1, $person->getId());
    }

    public function testSearchByNameIPLogger(): void
    {
        $person = $this->entityManager
            ->getRepository(IPLogger::class)
            ->findOneBy(['Name' => 'Dante'])
        ;
        $this->assertSame("666.666.666.1", $person->getIP());
    }

}

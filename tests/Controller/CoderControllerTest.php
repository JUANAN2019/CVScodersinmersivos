<?php

namespace App\Test\Controller;

use App\Entity\Coder;
use App\Repository\CoderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CoderControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CoderRepository $repository;
    private string $path = '/coder/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Coder::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Coder index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'coder[name]' => 'Testing',
            'coder[surname]' => 'Testing',
            'coder[description]' => 'Testing',
            'coder[url]' => 'Testing',
            'coder[fkCompetence]' => 'Testing',
            'coder[fkCourse]' => 'Testing',
        ]);

        self::assertResponseRedirects('/coder/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Coder();
        $fixture->setName('My Title');
        $fixture->setSurname('My Title');
        $fixture->setDescription('My Title');
        $fixture->setUrl('My Title');
        $fixture->setFkCompetence('My Title');
        $fixture->setFkCourse('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Coder');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Coder();
        $fixture->setName('My Title');
        $fixture->setSurname('My Title');
        $fixture->setDescription('My Title');
        $fixture->setUrl('My Title');
        $fixture->setFkCompetence('My Title');
        $fixture->setFkCourse('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'coder[name]' => 'Something New',
            'coder[surname]' => 'Something New',
            'coder[description]' => 'Something New',
            'coder[url]' => 'Something New',
            'coder[fkCompetence]' => 'Something New',
            'coder[fkCourse]' => 'Something New',
        ]);

        self::assertResponseRedirects('/coder/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getSurname());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getUrl());
        self::assertSame('Something New', $fixture[0]->getFkCompetence());
        self::assertSame('Something New', $fixture[0]->getFkCourse());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Coder();
        $fixture->setName('My Title');
        $fixture->setSurname('My Title');
        $fixture->setDescription('My Title');
        $fixture->setUrl('My Title');
        $fixture->setFkCompetence('My Title');
        $fixture->setFkCourse('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/coder/');
    }
}

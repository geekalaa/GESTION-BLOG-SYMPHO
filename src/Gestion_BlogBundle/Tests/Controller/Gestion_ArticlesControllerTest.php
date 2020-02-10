<?php

namespace Gestion_BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Gestion_ArticlesControllerTest extends WebTestCase
{
    public function testAjouter()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'ajouter-article');
    }

}

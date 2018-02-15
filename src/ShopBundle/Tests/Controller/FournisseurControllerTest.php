<?php

namespace ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FournisseurControllerTest extends WebTestCase
{
    public function testReadfournisseur()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/readFournisseur');
    }

}

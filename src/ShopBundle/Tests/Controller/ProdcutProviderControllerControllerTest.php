<?php

namespace ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProdcutProviderControllerControllerTest extends WebTestCase
{
    public function testCreateproduct()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'createProduct');
    }

    public function testUpdateproduct()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/updateProduct');
    }

    public function testShowproduct()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showProduct');
    }

    public function testDeleteproduct()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteProduct');
    }

}

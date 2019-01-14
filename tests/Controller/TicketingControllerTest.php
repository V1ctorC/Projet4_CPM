<?php
/**
 * Created by PhpStorm.
 * User: VictorChevalier
 * Date: 2018-12-26
 * Time: 12:15
 */

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TicketingControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function showHomepage()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function contentHomepage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Billetterie du musée du Louvre")')
        ->count());
    }

    /**
     * @test
     */
    public function redirect()
    {
        $client = static::createClient();

        $client->request('GET', '/summary');

        $this->assertTrue($client->getResponse()->isRedirect());
    }

    /**
     * @test
     */
    public function notFound()
    {
        $client = static::createClient();

        $client->request('GET', '/summary/1');

        $this->assertTrue($client->getResponse()->isNotFound());
    }
}
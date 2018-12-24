<?php
/**
 * Created by PhpStorm.
 * User: VictorChevalier
 * Date: 2018-12-21
 * Time: 16:24
 */

namespace App\Tests\Controller;

use App\Controller\TicketingController;
use PHPUnit\Framework\TestCase;
use App\Entity\Booking;
use App\Entity\Information;


class TicketingControllerTest extends TestCase
{
    public function testAddInformation()
    {
        $information = new Information();
        $information->setFirstname('Victor');
        $information->setLastname('Chevalier');
        $information->setBirthdate(new \DateTime('2018-09-28'));
        $information->setCountry('FR');
        $information->setReducedprice(1);
        $information->setAge(24);
        $information->setPrice(10);

        $this->assertContainsOnly(
            'string', [$information->getFirstname(), $information->getLastname(), $information->getCountry()]);

    }
}
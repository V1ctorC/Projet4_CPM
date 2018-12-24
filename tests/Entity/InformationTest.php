<?php
/**
 * Created by PhpStorm.
 * User: VictorChevalier
 * Date: 2018-12-24
 * Time: 14:19
 */

namespace App\Tests\Entity;


use App\Entity\Information;
use App\Entity\Booking;
use PHPUnit\Framework\TestCase;

class InformationTest extends TestCase
{
    /**
     * @test
     */
    public function InformationGet()
    {
        $information = new Information();

        $information->setFirstname('test');
        $information->setLastname('test');
        $information->setBirthdate(new \DateTime('2000-12-24'));
        $information->setCountry('FR');
        $information->setReducedprice(true);
        $information->setAge(18);
        $information->setPrice(10);

        $age = $information->getAge();

        $this->assertEquals(18, $age);
    }

    /**
     * @test
     */
    public function InformationGetBooking()
    {
        $booking = new Booking();

        $booking->setBookingnumber('1234567890');
        $booking->setBookingday(new \DateTime('today'));
        $booking->setType('W');
        $booking->setPaid(true);
        $booking->setQuantity(1);
        $booking->setMail('test@test.com');

        $information = new Information();

        $information->setFirstname('test');
        $information->setLastname('test');
        $information->setBirthdate(new \DateTime('2000-12-24'));
        $information->setCountry('FR');
        $information->setReducedprice(true);
        $information->setAge(18);
        $information->setPrice(10);
        $information->setIdbooking($booking);

        $paid = $information->getIdbooking()->getPaid();

        $this->assertEquals(true, $paid);

    }
}
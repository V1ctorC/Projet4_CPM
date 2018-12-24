<?php
/**
 * Created by PhpStorm.
 * User: VictorChevalier
 * Date: 2018-12-24
 * Time: 14:01
 */

namespace App\Tests\Entity;


use App\Entity\Booking;
use PHPUnit\Framework\TestCase;

class BookingTest extends TestCase
{
    /**
     * @test
     */
    public function bookingGet()
    {
        $booking = new Booking();

        $booking->setBookingnumber('1234567890');
        $booking->setBookingday(new \DateTime('today'));
        $booking->setType('W');
        $booking->setPaid(true);
        $booking->setQuantity(1);
        $booking->setMail('test@test.com');

        $mail = $booking->getMail();

        $this->assertEquals('test@test.com', $mail);
    }
}
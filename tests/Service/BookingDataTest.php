<?php
/**
 * Created by PhpStorm.
 * User: VictorChevalier
 * Date: 2018-12-24
 * Time: 09:54
 */

namespace App\Tests\Service;


use PHPUnit\Framework\TestCase;
use App\Entity\Booking;

class BookingDataTest extends TestCase
{
    /**
     * @test
     */
    public function generateBookingNumber()
    {
        $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        $bookingNumber = substr(str_shuffle(str_repeat($characters, 10)), 0, 10);
        $bookingNumber2 = substr(str_shuffle(str_repeat($characters, 10)), 0, 10);

        $this->assertNotEquals($bookingNumber, $bookingNumber2);
    }

    /**
     * @test
     */
    public function ticketSoldHigherThan1000()
    {
        $day = new \DateTime('today');
        $quantityOldBooking = 0;

        for ($i = 0; $i < 3; $i++)
        {
            $user[$i] = new Booking();
            $user[$i]->setBookingNumber('01234556789');
            $user[$i]->setBookingDay($day);
            $user[$i]->setType('H');
            $user[$i]->setPaid(true);
            $user[$i]->setQuantity(400);
            $user[$i]->setMail('test@test.com');

        }

        foreach ($user as $customer)
        {
            $quantityOldBooking = $quantityOldBooking + $customer->getQuantity();
        }

        if ($quantityOldBooking >= 1000)
        {
            $test = false;
        }
        else
        {
            $test = true;
        }

        $this->assertFalse($test);

    }

    /**
     * @test
     */
    public function ticketSoldLessThan1000()
    {
        $day = new \DateTime('today');
        $quantityOldBooking = 0;

        for ($i = 0; $i < 2; $i++)
        {
            $user[$i] = new Booking();
            $user[$i]->setBookingNumber('01234556789');
            $user[$i]->setBookingDay($day);
            $user[$i]->setType('H');
            $user[$i]->setPaid(true);
            $user[$i]->setQuantity(400);
            $user[$i]->setMail('test@test.com');

        }

        foreach ($user as $customer)
        {
            $quantityOldBooking = $quantityOldBooking + $customer->getQuantity();
        }

        if ($quantityOldBooking >= 1000)
        {
            $test = false;
        }
        else
        {
            $test = true;
        }

        $this->assertTrue($test);

    }

    /**
     * @test
     */
    public function verifyTypeCurrentDayAfter2PM()
    {
        $bookingDate = new \DateTime('2018-12-24');
        $bookingDate = $bookingDate->format('d-m-Y');

        $currentDate = new \DateTime('2018-12-24 14:30:15');
        $currentHourUTC = $currentDate->format('H');
        $currentHourUTC1 = $currentHourUTC + 1;
        $currentDate = $currentDate->format('d-m-Y');

        if (($bookingDate == $currentDate) && ($currentHourUTC1 >= 14))
        {
            $type = 'H';
        }
        else
        {
            $type = 'W';
        }

        $this->assertEquals('H', $type);
    }

    /**
     * @test
     */
    public function verifyTypeCurrentDayBefore2PM()
    {
        $bookingDate = new \DateTime('2018-12-24');
        $bookingDate = $bookingDate->format('d-m-Y');

        $currentDate = new \DateTime('2018-12-24 10:30:15');
        $currentHourUTC = $currentDate->format('H');
        $currentHourUTC1 = $currentHourUTC + 1;
        $currentDate = $currentDate->format('d-m-Y');

        if (($bookingDate == $currentDate) && ($currentHourUTC1 >= 14))
        {
            $type = 'H';
        }
        else
        {
            $type = 'W';
        }

        $this->assertEquals('W', $type);
    }
}
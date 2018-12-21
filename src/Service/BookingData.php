<?php
/**
 * Created by PhpStorm.
 * User: VictorChevalier
 * Date: 2018-12-21
 * Time: 14:02
 */

namespace App\Service;


class BookingData
{
    public function generateBookingNumber($booking)
    {
        $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $bookingNumber = substr(str_shuffle(str_repeat($characters, 10)), 0, 10);
        $booking->setBookingnumber($bookingNumber);

        return;
    }

    public function ticketsSold($listTickets)
    {
        $quantityOldBooking = 0;

        foreach ($listTickets as $oldBooking)
        {
            $quantityOldBooking = $quantityOldBooking + $oldBooking->getQuantity();
        }

        if ($quantityOldBooking >= 1000)
        {
            return false;
        }

        return true;
    }

    public function AjaxSold($ticketSoldDay)
    {
        $nbVisitors = 0;

        foreach ($ticketSoldDay as $booking)
        {
            $visitor = $booking->getQuantity();
            $nbVisitors = $nbVisitors + $visitor;
        }

        return $nbVisitors;
    }

    public function verifyType($booking)
    {
        $bookingDate = $booking->getBookingDay()->format('d-m-Y');
        $currentDate = new \DateTime('now');
        $currentHourUTC = $currentDate->format('H');
        $currentHourUTC1 = $currentHourUTC + 1;
        $currentDate = $currentDate->format('d-m-Y');

        if (($bookingDate == $currentDate) && ($currentHourUTC1 >= 14))
        {
            $booking->setType('H');
        }

        return;
    }
}
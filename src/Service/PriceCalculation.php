<?php
/**
 * Created by PhpStorm.
 * User: VictorChevalier
 * Date: 2018-12-10
 * Time: 10:51
 */

namespace App\Service;


class PriceCalculation
{
    public function getAge($birthdate)
    {
        $datetime1 = $birthdate;
        $datetime2 = new \DateTime('now');
        $interval = $datetime1->diff($datetime2);

        return $interval->format('%y');
    }

    public function priceAge($age, $reduced)
    {
        if ($reduced == true)
        {
            return $price = 10;
        }
        elseif (($age < 12) && ($age >= 4) )
        {
            return $price = 8;
        }
        elseif ($age < 4)
        {
            return $price = 0;
        }
        elseif ($age >= 60)
        {
            return $price = 12;
        }
        else
        {
            return $price = 16;
        }
    }

    public function priceTicketType($priceDay, $type)
    {
        if ($type == "H")
        {
            return $price = $priceDay/2;
        }

        return $priceDay;
    }


    public function addAgePrice($user, $booking)
    {
        $quantity = $booking->getQuantity();
        $ticketType = $booking->getType();

        for ($i=0;$i<$quantity;$i++)
        {
            $customer = $user[$i];
            $customer->setAge($this->getAge($customer->getBirthdate()));
            $priceDay = ($this->priceAge($customer->getAge(), $customer->getReducedprice()));
            $customer->setPrice($this->priceTicketType($priceDay, $ticketType));
            $customer->setIdbooking($booking);
        }
    }

    public function calculationSum($user)
    {
        $sum = 0;

        foreach ($user as $customer)
        {
            $price = $customer->getPrice();
            $sum = $sum + $price;
        }

        return $sum;
    }

    public function tryStripe ($token, $sum, $to, $booking)
    {
        try
        {
            $charge = \Stripe\Charge::create([
                'amount' => $sum * 100,
                'currency' => 'eur',
                'description' => 'Musée du Louvre',
                'source' => $token,
            ]);
            $booking->setMail($to);
            $booking->setPaid(true);

            return true;


        } catch (\Stripe\Error\Card $e) {

            return false;

        }

    }
}
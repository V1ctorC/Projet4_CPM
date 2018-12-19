<?php
/**
 * Created by PhpStorm.
 * User: VictorChevalier
 * Date: 2018-12-10
 * Time: 10:51
 */

namespace App\Service;


class CalculationDate
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
        if (($age < 12) && ($age >= 4) )
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
}
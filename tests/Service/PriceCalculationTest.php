<?php
/**
 * Created by PhpStorm.
 * User: VictorChevalier
 * Date: 2018-12-24
 * Time: 10:46
 */

namespace App\Tests\Service;


use App\Entity\Information;
use PHPUnit\Framework\TestCase;

class PriceCalculationTest extends TestCase
{
    /**
     * @test
     */
    public function getAge()
    {
        $datetime1 = new \DateTime('2009-12-29');
        $datetime2 = new \DateTime('2018-12-24');
        $interval = $datetime1->diff($datetime2);

        $age = $interval->format('%y');

        $this->assertEquals(8, $age);
    }

    /**
     * @test
     */
    public function priceAge16yReduced()
    {
        $age = 16;
        $reduced = true;

        if ($reduced == true)
        {
            $price = 10;
        }
        if (($age < 12) && ($age >= 4) )
        {
            $price = 8;
        }
        elseif ($age < 4)
        {
            $price = 0;
        }
        elseif ($age >= 60)
        {
            $price = 12;
        }
        elseif ($reduced == false && $age >= 12 && $age < 60)
        {
            $price = 16;
        }

        $this->assertEquals(10, $price);
    }

    /**
     * @test
     */
    public function priceAge3y()
    {
        $age = 3;
        $reduced = false;

        if ($reduced == true)
        {
            $price = 10;
        }
        if (($age < 12) && ($age >= 4) )
        {
            $price = 8;
        }
        elseif ($age < 4)
        {
            $price = 0;
        }
        elseif ($age >= 60)
        {
            $price = 12;
        }
        elseif ($reduced == false && $age >= 12 && $age < 60)
        {
            $price = 16;
        }

        $this->assertEquals(0, $price);
    }

    /**
     * @test
     */
    public function priceAge9y()
    {
        $age = 9;
        $reduced = false;

        if ($reduced == true)
        {
            $price = 10;
        }
        if (($age < 12) && ($age >= 4) )
        {
            $price = 8;
        }
        elseif ($age < 4)
        {
            $price = 0;
        }
        elseif ($age >= 60)
        {
            $price = 12;
        }
        elseif ($reduced == false && $age >= 12 && $age < 60)
        {
            $price = 16;
        }

        $this->assertEquals(8, $price);
    }

    /**
     * @test
     */
    public function priceAge60y()
    {
        $age = 60;
        $reduced = false;

        if ($reduced == true)
        {
            $price = 10;
        }
        if (($age < 12) && ($age >= 4) )
        {
            $price = 8;
        }
        elseif ($age < 4)
        {
            $price = 0;
        }
        elseif ($age >= 60)
        {
            $price = 12;
        }
        elseif ($reduced == false && $age >= 12 && $age < 60)
        {
            $price = 16;
        }

        $this->assertEquals(12, $price);
    }

    /**
     * @test
     */
    public function priceAgeOther()
    {
        $age = 41;
        $reduced = false;

        if ($reduced == true)
        {
            $price = 10;
        }
        if (($age < 12) && ($age >= 4) )
        {
            $price = 8;
        }
        elseif ($age < 4)
        {
            $price = 0;
        }
        elseif ($age >= 60)
        {
            $price = 12;
        }
        elseif ($reduced == false && $age >= 12 && $age < 60)
        {
            $price = 16;
        }

        $this->assertEquals(16, $price);
    }

    /**
     * @test
     */
    public function priceTicketTypeWholeDay()
    {
        $type = "W";
        $priceDay = 16;

        if ($type == "H")
        {
            $price = $priceDay/2;
        }
        else
        {
            $price = $priceDay;
        }

        $this->assertEquals(16, $price);
    }

    /**
     * @test
     */
    public function priceTicketTypeHalfDay()
    {
        $type = "H";
        $priceDay = 16;

        if ($type == "H")
        {
            $price = $priceDay/2;
        }
        else
        {
            $price = $priceDay;
        }

        $this->assertEquals(8, $price);
    }

    /**
     * @test
     */
    public function calculationSum()
    {
        $birthday = new \DateTime('1994-09-28');
        $sum = 0;

        for ($i = 0; $i < 5; $i++)
        {
            $user[$i] = new Information();
            $user[$i]->setFirstname('Test');
            $user[$i]->setLastname('Test');
            $user[$i]->setBirthdate($birthday);
            $user[$i]->setCountry('FR');
            $user[$i]->setReducedPrice(true);
            $user[$i]->setAge(24);
            $user[$i]->setPrice(10);
        }

        foreach ($user as $customer)
        {
            $price = $customer->getPrice();
            $sum = $sum + $price;
        }

        $this->assertEquals(50, $sum);
    }

}
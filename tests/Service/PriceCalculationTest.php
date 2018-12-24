<?php
/**
 * Created by PhpStorm.
 * User: VictorChevalier
 * Date: 2018-12-24
 * Time: 10:46
 */

namespace App\Tests\Service;


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

        $this->assertEquals('10', $age);
    }
}
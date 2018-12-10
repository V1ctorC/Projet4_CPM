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
        $am = explode('/', $birthdate);
        $an = explode('/', date('d/m/Y'));

        if(($am[1] < $an[1]) || (($am[1] == $an[1]) && ($am[0] <= $an[0])))
        {
            return $an[2] - $am[2];

        } else {

            return $an[2] - $am[2] - 1;
        }

    }
}
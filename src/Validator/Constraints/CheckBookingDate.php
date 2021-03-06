<?php
/**
 * Created by PhpStorm.
 * User: VictorChevalier
 * Date: 2018-12-20
 * Time: 11:11
 */

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CheckBookingDate extends Constraint
{
    public $message = "Il y a un problème avec la date que vous avez indiqué";

    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }
}
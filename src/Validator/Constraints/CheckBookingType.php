<?php
/**
 * Created by PhpStorm.
 * User: VictorChevalier
 * Date: 2018-12-20
 * Time: 14:28
 */

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CheckBookingType extends Constraint
{
    public $message = "Il y a un problème avec le type de ticket sélectionné";

    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }
}
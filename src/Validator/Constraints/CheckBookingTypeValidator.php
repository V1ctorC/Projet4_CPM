<?php
/**
 * Created by PhpStorm.
 * User: VictorChevalier
 * Date: 2018-12-20
 * Time: 14:31
 */

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CheckBookingTypeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        dump($value);
        if ("H" !== $value)
        {
            if ("W" !== $value)
            {
                $this->context->buildViolation("Veuillez choisir entre 1 journée et 1/2 journée")
                    ->addViolation();
            }
        }

        if (null === $value || '' === $value) {
            return;
        }
    }
}
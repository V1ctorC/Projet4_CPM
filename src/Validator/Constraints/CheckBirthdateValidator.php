<?php
/**
 * Created by PhpStorm.
 * User: VictorChevalier
 * Date: 2018-12-20
 * Time: 15:05
 */

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CheckBirthdateValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {

        if ($value instanceof \DateTime) {

            $dateYearNumber = $value->format('Y');

            if ($dateYearNumber < 1900) {
                $this->context->buildViolation("Vous ne pouvez pas être né avant 1900")
                    ->addViolation();
            }
        }

    }
}
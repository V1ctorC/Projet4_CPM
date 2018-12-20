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
        $dateDayNumber = $value->format('d');
        $dateMonthNumber = $value->format('m');
        $dateYearNumber = $value->format('Y');
        $completeDate = $value->format('Y-m-d');
        $currentDate=date('Y-m-d');


        if ($completeDate >= $currentDate )
        {
            $this->context->buildViolation("Vous devez être né avant aujourd'hui")
                ->addViolation();
        }

        if (checkdate($dateMonthNumber, $dateDayNumber, $dateYearNumber) != true)
        {
            $this->context->buildViolation("Le format de la date n'est pas valide")
                ->addViolation();
        }

        if ($dateMonthNumber < 1)
        {
            $this->context->buildViolation("Le mois doit être au minimum à 1")
                ->addViolation();
        }

        if ($dateMonthNumber > 12)
        {
            $this->context->buildViolation("Le mois doit être au maximum à 12")
                ->addViolation();
        }

        if ($dateDayNumber < 1)
        {
            $this->context->buildViolation("Le jour doit être au minimum à 1")
                ->addViolation();
        }

        if ($dateDayNumber > 31)
        {
            $this->context->buildViolation("Le jour doit être au maximum à 31")
                ->addViolation();
        }

        if ($dateYearNumber < 1900)
        {
            $this->context->buildViolation("Vous ne pouvez pas être né avant 1900")
                ->addViolation();
        }

    }
}
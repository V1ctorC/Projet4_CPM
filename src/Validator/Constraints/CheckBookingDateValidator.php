<?php
/**
 * Created by PhpStorm.
 * User: VictorChevalier
 * Date: 2018-12-20
 * Time: 11:14
 */

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CheckBookingDateValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ($value instanceof \DateTime)
        {
            $dateDay = $value->format('D');
            $dateDayNumber = $value->format('d');
            $dateMonthNumber = $value->format('m');
            $dateYearNumber = $value->format('Y');
            $completeDate = $value->format('Y-m-d');
            $futureDate=date('Y-m-d', strtotime('+1 year'));


            if ($completeDate > $futureDate )
            {
                $this->context->buildViolation("Vous ne pouvez pas réserver plus de 1 an à l'avance")
                    ->addViolation();
            }


            if (checkdate($dateMonthNumber, $dateDayNumber, $dateYearNumber) != true)
            {
                $this->context->buildViolation("Le format de la date n'est pas valide")
                    ->addViolation();
            }

            if ($dateDay == 'Sun')
            {
                $this->context->buildViolation('Le musée est fermé le Dimanche')
                    ->addViolation();
            }

            if ($dateDay == 'Tue')
            {
                $this->context->buildViolation('Le musée est fermé le Mardi')
                    ->addViolation();
            }

            if ($dateDayNumber == '01' && $dateMonthNumber == '05')
            {
                $this->context->buildViolation('Le musée est fermé le 1 mai')
                    ->addViolation();
            }

            if ($dateDayNumber == '01' && $dateMonthNumber == '11')
            {
                $this->context->buildViolation('Le musée est fermé le 1 novembre')
                    ->addViolation();
            }

            if ($dateDayNumber == '25' && $dateMonthNumber == '12')
            {
                $this->context->buildViolation('Le musée est fermé le 25 décembre')
                    ->addViolation();
            }
        }

    }
}
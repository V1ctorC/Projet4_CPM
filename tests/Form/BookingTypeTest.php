<?php
/**
 * Created by PhpStorm.
 * User: VictorChevalier
 * Date: 2018-12-26
 * Time: 10:26
 */

namespace App\Tests\Form;


use App\Entity\Booking;
use App\Form\BookingType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class BookingTypeTest extends TypeTestCase
{
    private $validator;

    protected function getExtensions()
    {
        $this->validator = $this->createMock(ValidatorInterface::class);

        $this->validator
            ->method('validate')
            ->will($this->returnValue(new ConstraintViolationList()));
        $this->validator
            ->method('getMetadataFor')
            ->will($this->returnValue(new ClassMetadata(Form::class)));

        return array(
            new ValidatorExtension($this->validator),
        );
    }

    public function testSubmitValidData()
    {
        $date = new \DateTime();


        $formData = array(
            'bookingday' => $date,
            'type' => 'W',
            'quantity' => 1,
        );

        $objectToCompare = new Booking();
        $objectToCompare->setBookingday($date);

        $form = $this->factory->create(BookingType::class, $objectToCompare);

        $object = new Booking();
        $object->setBookingday($date);
        $object->setType('W');
        $object->setQuantity(1);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($object, $objectToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key)
        {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
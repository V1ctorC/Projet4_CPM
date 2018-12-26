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
use Symfony\Component\Form\Test\TypeTestCase;

class InformationTypeTest extends TypeTestCase
{
    /*
    /**
     * @test
     *//*
    public function testSubmitValidData()
    {

        $formData = array(
            'bookingNumber' => '1234567890',
            'bookingDay' => '2018-12-26',
            'type' => 'W',
            'paid' => true,
            'quantity' => 1,
            'mail' => 'test@test.com'
        );

        $objectToCompare = new Booking();

        $form = $this->factory->create(BookingType::class, $objectToCompare);

        $object = new Booking();
        $object->setBookingnumber('1234567890');
        $object->setBookingday(new \DateTime('today'));
        $object->setType('W');
        $object->setPaid(true);
        $object->setQuantity(1);
        $object->setMail('test@test.com');

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($object, $objectToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key)
        {
            $this->assertArrayHasKey($key, $children);
        }
    }*/
}
<?php

//src/UserManagementBundle/Form/TaskType.php
namespace UserManagementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('dateofbirth', DateType::class)
//            ->add('email', EmailType::class)
            ->add('emails', CollectionType::class, array(
                'entry_type'   => EmailType::class,
                'entry_options'  => array(
                    'attr'      => array('class' => 'email-box'),
                ),
                'allow_add' => true,
             ))
            ->add('gender', ChoiceType::class, array(
    		'choices'  => array(
                    'male' => 'male',
                    'female' => 'female',
    		), 
    		'expanded' => true,
    		'multiple' => false,
       	    ))
            ->add('bloodgroup', ChoiceType::class, array(
                'choices'  => array(
                    'A+' => 'A+',
                    'A-' => 'A-',
                    'AB+' => 'AB+',
                    'AB-' => 'AB-',
                    'B+' => 'B+',
                    'B-' => 'B-',
                    'O+' => 'O+',
                    'O-' => 'O-',
                ), 
                'expanded' => false,
                'multiple' => false,
                ))
            ->add('course', ChoiceType::class, array(
                'choices'  => array(
                    'SSLC' => '10',
                    'HSC' => '12',
                    'UG' => 'ug',
                    'PG' => 'pg',
                ), 
                'expanded' => false,
                'multiple' => false,
                ))
            ->add('stream', TextType::class)
            ->add('college', TextType::class)
            ->add('location', TextType::class)
            ->add('mobilenumber', TextType::class)
            ->add('areaofinterest', ChoiceType::class, array(
                'choices'  => array(
                    'playing' => 'playing',
                    'reading' => 'reading',
                    'watching' => 'watching',
                ), 
                'expanded' => true,
                'multiple' => true,
                ))
            ->add('save', SubmitType::class, array('label' => 'Submit'))
        ;
    }
}
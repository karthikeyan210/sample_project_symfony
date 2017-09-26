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
            ->add('dateofbirth', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'format' => 'mm-dd-yyyy',
            ))
//            ->add('email', EmailType::class)
            ->add('emails', CollectionType::class, array(
                'entry_type'   => EmailType::class,
                'entry_options'  => array(
                    'attr'      => array('class' => 'email-id'),
                ),
                'allow_add' => true,
                'allow_delete' => true,
             ))
            ->add('mobilenumber', CollectionType::class, array(
                'entry_type'   => TextType::class,
                'entry_options'  => array(
                    'attr'      => array('class' => 'mobile-no'),
                ),
                'allow_add' => true,
                'allow_delete' => true
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
                'expanded' => true,
                'multiple' => true,
                ))
//            ->add('stream', TextType::class)
//            ->add('college', TextType::class)
//            ->add('location', TextType::class)
            ->add('areaofinterest', ChoiceType::class, array(
                'choices'  => array(
                    'playing' => 'playing',
                    'reading' => 'reading',
                    'watching' => 'watching',
                ), 
                'expanded' => true,
                'multiple' => true,
                ))
            ->add('username', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Submit'))
        ;
    }
}
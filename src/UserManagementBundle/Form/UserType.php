<?php

// src/UserManagementBundle/Form/Type/TaskType.php
namespace UserManagementBundle\Form;

use UserManagementBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'attr' => array(
                    'data-required' => 'true',
                    'fieldType' => 'username',
                ),
            ))
            ->add('firstname', TextType::class, array(
                'attr' => array(
                    'data-required' => 'true',
                    'fieldType' => 'name',
                ),
            ))
            ->add('lastname', TextType::class, array(
                'attr' => array(
                    'fieldType' => 'name',
                ),
            ))
            ->add('dob', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'attr' => array(
                    'class' => 'js-datepicker',
                    'data-required' => 'true',
                    'fieldType' => 'dob',
                ),
                'format' => 'MM/dd/yyyy',
            ))
            ->add('gender', EntityType::class, array(
                'class' => 'UserManagementBundle:Gender',
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => true,
            ))
            ->add('blood', EntityType::class, array(
                'class' => 'UserManagementBundle:BloodGroup',
                'choice_label' => 'name',
                'required' => false,
            ))
            ->add('emails', CollectionType::class, array(
                'entry_type' => UserEmailType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
                'entry_options' => array(
                    'attr' => array('class' => 'email_id'),
                )
            ))
            ->add('mobileNumbers', CollectionType::class, array(
                'entry_type' => UserPhoneType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
                'entry_options' => array(
                    'attr' => array('class' => 'phone_number'),
                )
            ))
            ->add('education', CollectionType::class, array(
                'entry_type' => UserEducationType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
                'entry_options' => array(
                    'attr' => array('class' => 'education_type'),
                )
            ))
            ->add('interests', CollectionType::class, array(
                'entry_type' => UserInterestType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
                'entry_options' => array(
                    'attr' => array('class' => 'interest_area'),
                )
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Submit',
                'attr' => array('id' => 'user_save'),
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}
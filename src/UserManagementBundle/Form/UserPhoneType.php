<?php

// src/UserManagementBundle/Form/Type/TagType.php
namespace UserManagementBundle\Form;

use UserManagementBundle\Entity\UserPhone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserPhoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('number');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => UserPhone::class,
        ));
    }
}
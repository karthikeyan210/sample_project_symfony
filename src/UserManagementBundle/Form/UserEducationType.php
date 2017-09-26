<?php

// src/UserManagementBundle/Form/Type/TagType.php
namespace UserManagementBundle\Form;

use UserManagementBundle\Entity\UserEducation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserEducationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('eduType', EntityType::class, array(
                'class' => 'UserManagementBundle:EducationType',
                'choice_label' => 'type',
                'multiple' => false,
                'expanded' => false,
            ))
            ->add('institute');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => UserEducation::class,
        ));
    }
}
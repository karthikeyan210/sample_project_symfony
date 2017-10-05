<?php

// src/UserManagementBundle/Form/Type/TagType.php
namespace UserManagementBundle\Form;

use UserManagementBundle\Entity\UserInterest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserInterestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('interest', EntityType::class, array(
                'class' => 'UserManagementBundle:Interest',
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'label' => false,
                'required' => false,
                'attr' => array(
//                    'data-required' => 'true',
                    'class' => 'interest_area',
                ),
            ));          
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => UserInterest::class,
        ));
    }
}
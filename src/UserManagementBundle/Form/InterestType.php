<?php

// src/UserManagementBundle/Form/Type/TagType.php
namespace UserManagementBundle\Form;

use UserManagementBundle\Entity\Interest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class InterestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('name', EntityType::class, array(
//                'class' => 'UserManagementBundle:BloodGroup',
//                'choice_label' => 'name',
//                'multiple' => false,
//                'expanded' => true,
//            ))
            ->add('name', TextType::class, array(
                'label' => false,
                'required' => false,
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'ADD',
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Interest::class,
        ));
    }
}
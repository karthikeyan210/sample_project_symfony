<?php

// src/UserManagementBundle/Form/Type/TagType.php
namespace UserManagementBundle\Form;

use UserManagementBundle\Form\DataTransformer\InterestToStringTransformer;
use UserManagementBundle\Entity\UserInterest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityManagerInterface;

class UserInterestType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('interest', TextType::class, array(
                'attr' => array(
                    'class' => 'interest_area',
                ),
                'label' => false,
                'invalid_message' => 'That is not a valid interest',
            ));
        $builder->get('interest')
            ->addModelTransformer(new InterestToStringTransformer($this->em));
   
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => UserInterest::class,
        ));
    }
}
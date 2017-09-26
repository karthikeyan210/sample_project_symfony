<?php

// src/SampleBundle/Form/Type/TagType.php
namespace SampleBundle\Form\Type;

use SampleBundle\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', EntityType::class, array(
                'class' => 'SampleBundle:Category',
                'choice_label' => function($category) {
                    return $category->getName();
                },
                'multiple' => false,
                'expanded' => false,
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Category::class,
        ));
    }
}
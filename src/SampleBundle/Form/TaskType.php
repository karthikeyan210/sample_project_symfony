<?php

//src/SampleBundle/Form/TaskType.php
namespace SampleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('task')
            ->add('dueDate', DateType::class, array('widget' => 'single_text', 
            	'placeholder' => 'due date'))
            ->add('firstname', TextType::class, array('required'  => false))
            ->add('lastname', TextType::class)
            ->add('dateofbirth', DateType::class, array('label'  => false))
            ->add('save', SubmitType::class, array('label' => 'Create Post'))
        ;
	}
}
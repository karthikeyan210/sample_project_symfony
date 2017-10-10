<?php

namespace UserManagementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

//use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label' => false,
                'required' => false,
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('password', PasswordType::class, array(
                'label' => false,
                'required' => false,
            ))
        ;
    }
}
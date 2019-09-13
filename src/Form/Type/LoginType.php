<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;


class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
                'choice_value' => 'username',
            ])
            ->add('_password', PasswordType::class)
            ->add('login', SubmitType::class);
    }
    public function getBlockPrefix()
    {
        return null;
    }
}
<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class'       => 'form-control relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm',
                    'placeholder' => 'Enter an email address',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Email cannot be blank']),
                    new Email(['message' => 'Please enter a valid email address']),
                ],
                'label'      => 'Email',
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'User'  => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                ],
                'multiple'    => true,
                'expanded'    => true,
                'choice_attr' => function ($choice, $key, $value) {
                    return ['class' => ' mx-2'];
                },
                'attr'        => ['class' => 'block text-sm font-medium text-gray-100 custom-checkbox-group'],
                'constraints' => [
                    new NotBlank(['message' => 'Please select at least one role']),
                ],
                'label'      => 'Roles',
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            ])
            ->add('password', PasswordType::class, [
                'attr' => [
                    'class'       => 'form-control relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm',
                    'placeholder' => 'Enter New Password',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Password cannot be blank']),
                ],
                'label'      => 'Password',
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            ])
            ->add('submit', SubmitType::class, [
                'attr'  => ['class' => 'w-full md:w-1/2 xl:w-1/4 px-4 py-2 rounded  bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none transition-colors'],
                'label' => 'Create User',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

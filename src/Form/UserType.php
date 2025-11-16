<?php

namespace App\Form;

use App\Entity\Stage;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use App\Form\UserType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('roles',ChoiceType::class, [
                'label' => 'Roles',
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Stagiaire' => 'ROLE_STAGIAIRE',
                    'Encadrant' => 'ROLE_ENCADRANT',
                    'Professeur' => 'ROLE_PROFESSEUR',
                ],
                'multiple' => true,
                'expanded' => true,
                ])
            ->add('plainPassword', PasswordType::class, [
                 'mapped' => false,
                 'label' => 'Mot de passe',
                 'attr' => ['autocomplete' => 'new-password'],
])

            ->add('stage', EntityType::class, [
                'class' => Stage::class,
                'choice_label' => 'sujet',
                'placeholder' => 'Sélectionnez un sujet de stage',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

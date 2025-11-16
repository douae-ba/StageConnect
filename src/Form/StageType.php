<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;


class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom')
            ->add('Prenom')
            ->add('Email')
            ->add('password')
            ->add('Encadrant',EntityType::class, [
                'class' => User::class,
                'choice_label' => function(User $user){
                    return $user->getNom().' '.$user->getPrenom();
                },
                'query_builder'=>function(EntityRepository $er){
                    return $er ->createQueryBuilder('u')
                    ->where('u.roles LIKE :role')
                    ->setParameter('role','%ROLE_ENCADRANT%');
                },
                'placeholder' => 'Choisir un encadrant',
                'label'=>'Encadrant',])
            ->add('Professeur', EntityType::class, [
    'class' => User::class,
    'choice_label' => function(User $user) {
        return $user->getNom() . ' ' . $user->getPrenom();
    },
    'query_builder' => function (EntityRepository $er) {
        return $er->createQueryBuilder('u')
                  ->where('u.roles LIKE :role')
                  ->setParameter('role', '%ROLE_PROFESSEUR%');
    },
    'placeholder' => 'Choisir un professeur',
    'label' => 'Professeur',
])
            ->add('dateDebut', DateType::class, [
        'widget' => 'single_text',
        'html5' => true,
        'label' => 'Date de début',
        'required' => true,
    ])
    ->add('dateFin', DateType::class, [
        'widget' => 'single_text',
        'html5' => true,
        'label' => 'Date de fin',
        'required' => true,
    ])
            ->add('Sujet')
            ->add('Etablissement')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}

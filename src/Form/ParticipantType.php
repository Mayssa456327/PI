<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Participant;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateParticipation')
            ->add('description')
            ->add('evenement', EntityType::class, [
                'class' => Evenement::class,
                'choice_label' => function (Evenement $evenement) {
                    // Personnalisez ici le libellé de votre choix
                    return $evenement->getNomEvenement(); // Remplacez getNom() par la méthode appropriée pour afficher le libellé souhaité
                },
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => function (User $user) {
                    // Personnalisez ici le libellé de votre choix
                    return $user->getEmail(); // Remplacez getUsername() par la méthode appropriée pour afficher le libellé souhaité
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }


}

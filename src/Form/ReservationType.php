<?php

namespace App\Form;

use App\Entity\Hopital;
use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\GreaterThan;


class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomPatient', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Le nom du patient est requis.']),
                ],
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width: 300px;', // Ajouter un style CSS pour augmenter la largeur du champ
                ],
            ])
            ->add('email', null, [
                'constraints' => [
                    new NotBlank(['message' => 'le mail du patient est requis.']),
                ],
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width: 300px;', // Ajouter un style CSS pour augmenter la largeur du champ
                ],
            ])
            ->add('telephone', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Le Telephone du patient est requis.']),
                ],
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width: 300px;', // Ajouter un style CSS pour augmenter la largeur du champ
                ],
            ])
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd',
                'constraints' => [
                    new NotBlank(['message' => 'La date de début est requise.']),
                    new GreaterThan([
                        'value' => 'today',
                        'message' => 'La date de début doit être ultérieure à aujourd\'hui.',
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width: 300px;', // Ajouter un style CSS pour augmenter la largeur du champ
                ],
            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd',
                'constraints' => [
                    new NotBlank(['message' => 'La date de début est requise.']),
                ],
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width: 300px;', // Ajouter un style CSS pour augmenter la largeur du champ
                ],
            ])
            ->add('Hopital', EntityType::class, [
                'class' => Hopital::class,
                'choice_label' => 'Nom',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner un hôpital.']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'dateFin' => null, 
        ]);
    }
}

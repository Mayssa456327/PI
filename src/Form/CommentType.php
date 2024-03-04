<?php

namespace App\Form;
use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;


class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'attr' => ['placeholder' => 'Enter your comment here...'],
                'constraints' => [
                    new Length([
                        'min' => 20, // Longueur minimale de 20 caractères
                        'minMessage' => 'Your comment must be at least {{ limit }} characters long', // Message en cas d'erreur
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Update',
                'attr' => ['class' => 'btn btn-primary'] // You can add classes or any other attributes here
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}

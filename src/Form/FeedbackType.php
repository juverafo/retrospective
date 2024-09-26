<?php

namespace App\Form;

use App\Entity\Feedback;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class FeedbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Positif' => 'positif',
                    'Négatif' => 'negatif',
                ],
                'label' => 'Type de feedback',
                'attr' => ['class' => 'form-select'],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Votre feedback',
                'attr' => ['class' => 'form-control', 'rows' => 4],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le contenu du feedback ne peut pas être vide.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Feedback::class,
        ]);
    }
}

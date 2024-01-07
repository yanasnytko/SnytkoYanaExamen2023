<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Livre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $modif = $options['modif'];

        
        $builder
            ->add('titre', TextType::class, [
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('resume', TextareaType::class, [
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('auteur', TextType::class, [
                'attr' => ['class' => 'form-control mb-3'],
            ])
        ;

        if (!$modif) {
            $builder
                ->add('dateParution', DateType::class, [
                    'widget' => 'single_text',
                    'required' => false,
                    'attr' => ['class' => 'form-control mb-3']
                ])
                ->add('genre', EntityType::class, [
                    'class' => Genre::class,
                    'choice_label' => 'nom',
                    'attr' => ['class' => 'form-control mb-3'],
                ]);
        }

        $builder->add('enregistrer', SubmitType::class, [
            'attr' => ['class' => 'btn btn-primary mb-3'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
            'modif' => false,
        ]);
    }
}

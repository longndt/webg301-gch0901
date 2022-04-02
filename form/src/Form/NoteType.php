<?php

namespace App\Form;

use App\Entity\Note;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                ->add('title', TextType::class,
                [
                    'label' => 'Note Title',
                    'required' => true,
                    'attr' => [
                        'minlength' => 3,
                        'maxlength' => 30
                    ]
                ])
                ->add('content', TextType::class,
                [
                    'label' => 'Note Content',
                    'required' => true
                ])
                ->add('date', DateType::class,
                [
                    'label' => 'Note Due Date',
                    'required' => true,
                    'widget' => 'single_text'
                ])
                ->add('Save', SubmitType::class)
                ;       
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}

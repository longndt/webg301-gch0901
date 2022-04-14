<?php

namespace App\Form;

use App\Entity\Laptop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LaptopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
            [
                'label' => 'Laptop Name',
                'required' => true  // Not Null : nullable = false
            ])
            ->add('brand', TextType::class,
            [
                'label' => 'Laptop Brand',
                'required' => true,
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 10
                ]
            ])
            ->add('price', MoneyType::class,
            [
                'label' => 'Laptop Price',
                'required' => true,
                'currency' => 'USD'
            ])
            ->add('quantity', IntegerType::class,
            [
                'label' => 'Laptop Quantity',
                'required' => true,
                'attr' => [
                    'min' => 20,
                    'max' => 80
                ]
            ])
            ->add('date', DateType::class,
            [
                'label' => 'Manufacture Date',
                'required' => true,
                'widget' => 'single_text'
            ])
            ->add('image', TextType::class,
            [
                'label' => 'Laptop Image',
                'required' => true
            ])
            ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Laptop::class,
        ]);
    }
}

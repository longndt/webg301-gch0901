<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Genre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,
            [
                'label' => 'Book Title',
                'required' => true,
                'attr' => [
                    'minlength' => 3,
                    'maxlength' => 30
                ]
            ])
            ->add('author', TextType::class,
            [
                'label' => 'Author Name',
                'required' => true,
                'attr' => [
                    'minlength' => 5,
                    'maxlength' => 50
                ]
            ])
            ->add('price', MoneyType::class,
            [
                'label' => 'Book Price',
                'required' => true,
            ])
            ->add('date', DateType::class,
            [
                'label' => 'Published Date',
                'required' => true,
                'widget' => 'single_text'
            ])
            ->add('image', TextType::class,
            [
                'label' => 'Book Cover',
                'required' => true
            ])
            ->add('genre', EntityType::class,
            [
                'label' => 'Genre name',
                'required' => true,
                'class' => Genre::class,
                'choice_label' => 'name',
                'multiple' => false,  
                'expanded' => false
                //multiple = true: ManyToMany, OneToMany => có thể chọn nhiều item
                //multiple = false: OneToOne, ManyToOne => chỉ được chọn 1 item
                //expanded = true: hiển thị danh sách mở rộng
                //expanded = false: hiển thị danh sách rút gọn
            ])
            ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}

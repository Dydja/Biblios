<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'Nom',
            ])
            ->add('dateOfBirth', null, [
                'input'=>'datetime_immutable',
                'widget' => 'single_text',
                'label' => 'Date d\'anniversaire',
            ])
            ->add('dateOfDeath',DateType::class, [
                'input'=>'datetime_immutable',
                'widget' => 'single_text',
                'label' => 'Date de décès',
                'required'=>false
            ])
            ->add('nationality',TextType::class,[
                'required'=>false,
                'label' => 'Nationnalité',
            ])

            ->add('books', EntityType::class, [
                'class' => Book::class,
                'choice_label' => 'id',
                'multiple' => true,
                'required'=>false,
                'label' => 'Livre',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}

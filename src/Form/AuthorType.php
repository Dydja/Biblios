<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'Nom',
                'required'=>false
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
                'label' => 'Nationnalité',
                'required'=>false,
            ])

            ->add('books', EntityType::class, [
                'class' => Book::class,
                'choice_label' => 'id',
                'multiple' => true,
                'label' => 'Livre',
                'required'=>false,
            ])

            ->add('certification', CheckboxType::class, [
                'mapped' => false,
                'label' => "Je certifie l'exactitude des informations fournies",
                'constraints' => [
                    new IsTrue(message: "Vous devez cocher la case pour ajouter un auteur."),
                ],
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

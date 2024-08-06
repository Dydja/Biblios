<?php

namespace App\Form;

use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Editor;
use App\Enum\BookStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                'label'=>'Titre',
                'required'=>true
            ])
            ->add('isbn',TextType::class,[
                'required'=>true,
                'label'=>'ISBN'
            ])
            ->add('cover',UrlType::class,[
                'required'=>true,
                'label'=>'Lien'
            ])
            ->add('editAt', null, [
                'input'=>'datetime_immutable',
                'widget' => 'single_text',
                'label'=>'Date d\'édition',
            ])
            ->add('plot',TextareaType::class,[
                'label'=>'Message'
            ])
            ->add('pageNumber', NumberType::class,[
                'label'=>'Nombre de page'
            ])
            ->add('status',EnumType::class,[
                'required'=>true,
                'label'=>'Statut',
                'class' => BookStatus::class,
            ])
            ->add('editor', EntityType::class, [
                'class' => Editor::class,
                'choice_label' => 'id',
                'label'=>'Maision d\'édition',
                'required'=>true
            ])
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'label'=>'Auteur',
                'choice_label' => 'id',
                'multiple' => true,
                'required'=>false,
                'by_reference' => false,
            ])

            ->add('certification', CheckboxType::class, [
                'mapped' => false,
                'label' => "Je certifie l'exactitude des informations fournies",
                'constraints' => [
                    new Assert\IsTrue(message: "Vous devez cocher la case pour ajouter un livre."),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

//Préfixe de mes routes pour ce fichier
#[Route('/admin/author')]
class AuthorController extends AbstractController
{
    /**
     * Affiche tous les auteurs via la function 
     * AuthorRepository
     */
    #[Route('', name: 'app_admin_author_index',methods:['GET'])]
    public function index(AuthorRepository $repository): Response
    {
        $authors = $repository->findAll();
        return $this->render('admin/author/index.html.twig', [
            'controller_name' => 'AuthorController',
            'authors'=>$authors
        ]);
    }

    //Ajout d'un auteur
    #[Route('/form','app_admin_author_form',methods:['GET','POST'])]
    public function create(Request $request,EntityManagerInterface $manager):Response
    {
        /**
         * On va créer une instance de notre entity Author
         * Auquelle je rattache mon formulaire
         */

         $author = new Author();
         $forms = $this->createForm(AuthorType::class,$author);

         /**
          * Traitement du formulaire
          * On vérifie si elle est soumis et valide
          */

          $forms->handleRequest($request);
          if ($forms->isSubmitted() && $forms->isValid()) {
              // Enregistrement en base de donnée
              $manager->persist($author);
              $manager->flush();

              return $this->redirectToRoute('app_admin_author_index');
          }
       
         return $this->render('admin/author/create.html.twig',[
           'form'=>$forms
        ]);
    }
}

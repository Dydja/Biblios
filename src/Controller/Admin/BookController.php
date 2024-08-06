<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/book')]
class BookController extends AbstractController
{
    #[Route('', name: 'app_admin_book_index',methods:'GET')]
    public function index(): Response
    {
        return $this->render('admin/book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/form', name: 'app_admin_book_form',methods:['GET','POST'])]
    public function create(Request $request,EntityManagerInterface $manager): Response
    {
        $book = new Book();
        $forms = $this->createForm(BookType::class,$book);

        $forms->handleRequest($request);
        if ($forms->isSubmitted() && $forms->isValid()) {
            // Enregistrer les data en BD
            $manager->persist($book);
            $manager->flush();

            return $this->redirectToRoute('app_admin_book_index');
        }

        return $this->render('admin/book/create.html.twig', [
            'form' => $forms,
        ]);
    }
}

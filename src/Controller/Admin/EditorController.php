<?php

namespace App\Controller\Admin;

use App\Entity\Editor;
use App\Form\EditorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/editor')]
class EditorController extends AbstractController
{
    #[Route('', name: 'app_admin_editor_index')]
    public function index(): Response
    {
        return $this->render('admin/editor/index.html.twig', [
            'controller_name' => 'EditorController',
        ]);
    }

    #[Route('/form', name: 'app_admin_editor_form',methods:['GET','POST'])]
    public function create(Request $request,EntityManagerInterface $manager):Response
    {
        $editor = new Editor();
        $forms = $this->createForm(EditorType::class,$editor);

         /**
          * Traitement du formulaire
          */

          $forms->handleRequest($request);
          if ($forms->isSubmitted() && $forms->isValid()) {
             
              // Enregistrer les data en BD
            $manager->persist($editor);
            $manager->flush();

            return $this->redirectToRoute('app_admin_editor_index');
          }
        return $this->render('admin/editor/create.html.twig',[
            'form'=>$forms
        ]);   
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategorieRepository;
use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Component\Security\Core\Security;


class CategorieController extends AbstractController
{
    #[Route('/categorielist', name: 'app_categorie')]
    public function index(CategorieRepository $cr,Security $sec): Response
    {
        if(!$sec->getUser()) return $this->redirectToRoute('app_login');
        $cat = $cr->findAll();
        // var_dump($cat);
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
            'categorie'=> $cat
        ]);
    }

    #[Route('/categorieadd', name: 'app_addcategorie')]
    public function addCategory(Request $request,EntityManagerInterface $entityManager,Security $sec): Response
    {
        if(!$sec->getUser()) return $this->redirectToRoute('app_login');
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            // var_dump ($categorie);
            
            $entityManager->persist($categorie);
            $entityManager->flush();
            

            return $this->redirectToRoute('app_categorie');
        }
        return $this->render('categorie/addcategorie.html.twig', [
            'categorieForm' => $form->createView(),
        ]);
    }
}

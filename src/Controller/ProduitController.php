<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use App\Entity\Categorie;
use App\Entity\Produit;
use App\Form\ProduitType;
use Symfony\Component\Security\Core\Security;
use App\Form\CategorieType;


class ProduitController extends AbstractController
{
    #[Route('/produitlist', name: 'app_produit')]
    public function index(ProduitRepository $prodrep,Security $sec): Response
    {
        if(!$sec->getUser()) return $this->redirectToRoute('app_login');
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
            'produits'=> $prodrep->findAll()
        ]);
    }

    #[Route('/produitadd', name: 'app_addproduit')]
    public function addCategory(Request $request,EntityManagerInterface $entityManager,CategorieRepository $cat,Security $sec): Response
    {
        if(!$sec->getUser()) return $this->redirectToRoute('app_login');
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categorie = $cat->find($_POST['produit']['categorie']);
            $produit->setCategorie($categorie);
            $produit->setUser($sec->getUser());
            $produit->setStock(0);
            $entityManager->persist($produit);
            $entityManager->flush();
            return $this->redirectToRoute('app_produit');
        }
        return $this->render('produit/addproduit.html.twig', [
            'produitForm' => $form->createView(),
        ]);
    }
}

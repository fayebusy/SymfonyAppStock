<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EntreeRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use App\Entity\Sortie;
use App\Form\SortieFormType;
use App\Entity\Produit;
use App\Form\ProduitType;
use Symfony\Component\Security\Core\Security;
use App\Form\CategorieType;
use App\Repository\SortieRepository;

class SortieController extends AbstractController
{
    #[Route('/sortielist', name: 'app_sortie')]
    public function index(SortieRepository $sorep,Security $sec): Response
    {
        if(!$sec->getUser()) return $this->redirectToRoute('app_login');
        return $this->render('sortie/index.html.twig', [
            'controller_name' => 'SortieController',
             'sorties'=> $sorep->findAll(),
        ]);
    }

    #[Route('/sortieadd', name: 'app_add_sortie')]
    public function addEntree(Request $request, EntityManagerInterface $entityManager, ProduitRepository $prod, Security $sec): Response
    {
        if(!$sec->getUser()) return $this->redirectToRoute('app_login');
        $sortie = new Sortie();
        $form = $this->createForm(SortieFormType::class, $sortie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $produit = $prod->find($_POST['sortie_form']['produit']);
            if ($produit->getStock() < $sortie->getQuantite()) return $this->render('sortie/addsortie.html.twig', [
                'sortieForm' => $form->createView(),
                'erreur' => 'Stock Insuffisant'
            ]);
            else {
                $produit->setStock($produit->getStock() - $sortie->getQuantite());
                $sortie->setProduit($produit);
                $entityManager->persist($sortie);
                $entityManager->flush();
                return $this->redirectToRoute('app_produit');
            }
        }
        return $this->render('sortie/addsortie.html.twig', [
            'sortieForm' => $form->createView(),
        ]);
    }
}

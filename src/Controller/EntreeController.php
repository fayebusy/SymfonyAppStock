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
use App\Entity\Entree;
use App\Form\EntreeFormType;
use App\Entity\Produit;
use App\Form\ProduitType;
use Symfony\Component\Security\Core\Security;
use App\Form\CategorieType;

class EntreeController extends AbstractController
{
    #[Route('/entreelist', name: 'app_entree')]
    public function index(EntreeRepository $entree,Security $sec): Response
    {
        if(!$sec->getUser()) return $this->redirectToRoute('app_login');
        return $this->render('entree/index.html.twig', [
            'controller_name' => 'EntreeController',
            'entrees'=> $entree->findAll()
        ]);
    }

    #[Route('/entreeadd', name: 'app_add_entree')]
    public function addEntree(Request $request,EntityManagerInterface $entityManager,ProduitRepository $prod,Security $sec): Response
    {
        if(!$sec->getUser()) return $this->redirectToRoute('app_login');
        $entree = new Entree();
        $form = $this->createForm(EntreeFormType::class, $entree);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $produit = $prod->find($_POST['entree_form']['produit']);
            $produit->setStock($produit->getStock()+$entree->getQuantite());
            $entree->setProduit($produit);
            
            
            $entityManager->persist($entree);
            $entityManager->flush();
            return $this->redirectToRoute('app_produit');
        }
        return $this->render('entree/addentree.html.twig', [
            'entreeForm' => $form->createView(),
        ]);
    }
}

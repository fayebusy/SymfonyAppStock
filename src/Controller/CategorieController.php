<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CategorieRepository;

class CategorieController extends AbstractController
{
    #[Route('/categorielist', name: 'app_categorie')]
    public function index(CategorieRepository $cr): Response
    {
        
        $cat = $cr->findAll();
        // var_dump($cat);
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
            'categorie'=> $cat
        ]);
    }
}

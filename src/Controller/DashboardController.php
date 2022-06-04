<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class DashboardController extends AbstractController
{
    #[Route('', name: 'app_dashboard')]
    public function index(Security $sec): Response
    {
        if(!$sec->getUser()) return $this->redirectToRoute('app_login');
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}

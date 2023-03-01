<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\SanctionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(SanctionsRepository $sanctionRepo, CategoriesRepository $categoryRepo): Response
    {
        $sanctions = $sanctionRepo->findAll();

        $categories = $categoryRepo->findAll();

        return $this->render('home/index.html.twig', [
            'Page_title' => 'Accueil',
            'sanctions'  => $sanctions,
            'categories' => $categories
        ]);
    }
}

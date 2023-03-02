<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\FormationsRepository;
use App\Repository\SanctionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(SanctionsRepository $sanctionRepo, CategoriesRepository $categoryRepo, FormationsRepository $formationRepo): Response
    {
        $sanctions = $sanctionRepo->findAll();
        $categories = $categoryRepo->findAll();
        $formations = $formationRepo->findAll();

        return $this->render('home/index.html.twig', [
            'Page_title' => 'Accueil',
            'sanctions'  => $sanctions,
            'categories' => $categories,
            'formations' => $formations
        ]);
    }
}

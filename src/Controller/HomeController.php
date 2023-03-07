<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\CategoriesRepository;
use App\Repository\FormationsRepository;
use App\Repository\SanctionsRepository;
use App\Repository\UniversitiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        SanctionsRepository $sanctionRepo,
        CategoriesRepository $categoryRepo,
        FormationsRepository $formationRepo,
        UniversitiesRepository $universityRepo,
        Request $request
    ): Response {

        $sanctions = $sanctionRepo->findAll();
        $categories = $categoryRepo->findAll();
        $universities = $universityRepo->findAll();
        

        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formations = $formationRepo->findFormationsBySearch($searchData, $request);
        } else {
            $formations = $formationRepo->findAllPaginate($request);
        }

        return $this->render('home/index.html.twig', [
            'Page_title'   => 'Accueil',
            'sanctions'    => $sanctions,
            'categories'   => $categories,
            'universities' => $universities,
            'formations'   => $formations,
            'form'          => $form->createView()
        ]);

    }

    #[Route('/{filter}', name: 'app_home_filter')]
    public function filter(
        SanctionsRepository $sanctionRepo,
        CategoriesRepository $categoryRepo,
        UniversitiesRepository $universityRepo,
        FormationsRepository $formationRepo,
        Request $request,
        ?string $filter
    ): Response {

        $sanctions = $sanctionRepo->findAll();
        $categories = $categoryRepo->findAll();
        $universities = $universityRepo->findAll();
        

        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formations = $formationRepo->findFormationsBySearch($searchData, $request);
        } else {
            $formations = $formationRepo->findFiltered($filter, $request);
        }

        return $this->render('home/index.html.twig', [
            'Page_title' => 'Accueil',
            'sanctions'  => $sanctions,
            'categories' => $categories,
            'universities' => $universities,
            'formations' => $formations,
            'form'       => $form->createView()
        ]);

    }
}

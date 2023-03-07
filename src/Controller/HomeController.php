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
    /**
     * @var SanctionsRepository
     */
    private SanctionsRepository $sanctionRepo;

    /**
     * @var CategoriesRepository
     */
    private CategoriesRepository $categoryRepo;

    /**
     * @var FormationsRepository
     */
    private FormationsRepository $formationRepo;

    /**
     * @var UniversitiesRepository
     */
    private UniversitiesRepository $universityRepo;

    public function __construct(SanctionsRepository $sanctionRepo, CategoriesRepository $categoryRepo, FormationsRepository $formationRepo, UniversitiesRepository $universityRepo) 
    {
        $this->sanctionRepo = $sanctionRepo;
        $this->categoryRepo = $categoryRepo;
        $this->formationRepo = $formationRepo;
        $this->universityRepo = $universityRepo;
    }

    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response 
    {

        $sanctions = $this->sanctionRepo->findAll();
        $categories = $this->categoryRepo->findAll();
        $universities = $this->universityRepo->findAll();
        

        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formations = $this->formationRepo->findFormationsBySearch($searchData, $request);
        } else {
            $formations = $this->formationRepo->findAllPaginate($request);
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
    public function filter(Request $request, ?string $filter): Response 
    {

        $sanctions = $this->sanctionRepo->findAll();
        $categories = $this->categoryRepo->findAll();
        $universities = $this->universityRepo->findAll();
        

        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formations = $this->formationRepo->findFormationsBySearch($searchData, $request);
        } else {
            $formations = $this->formationRepo->findFiltered($filter, $request);
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

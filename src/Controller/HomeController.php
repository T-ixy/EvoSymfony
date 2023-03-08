<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Functions\Construct;
use App\Model\SearchData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Construct
{

    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response 
    {
        
        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formations = $this->formationRepo->findFormationsBySearch($searchData, $request);
        } else {
            if ($request->query->has('formationSearch')) {
                parse_str($request->query->get('formationSearch'), $queryData);
                $searchData = new SearchData();
                $searchData->page = $queryData['page'];
                $searchData->search = $queryData['search'];
                $formations = $this->formationRepo->findFormationsBySearch($searchData, $request);
            }else{

                $formations = $this->formationRepo->findAllPaginate($request);
            }
        }
            

        return $this->render('home/index.html.twig', [
            'Page_title'   => 'Accueil',
            'sanctions'    => $this->sanctions,
            'categories'   => $this->categories,
            'universities' => $this->universities,
            'formations'   => $formations,
            'form'          => $form->createView()
        ]);

    }

    #[Route('/{filter}', name: 'app_home_filter')]
    public function filter(Request $request, ?string $filter): Response 
    {
        

        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formations = $this->formationRepo->findFormationsBySearch($searchData, $request);
            return $this->redirectToRoute('app_home', ['formationSearch' => http_build_query($searchData)]);
        } else {
            $formations = $this->formationRepo->findFiltered($filter, $request);
        }

        return $this->render('home/index.html.twig', [
            'Page_title' => 'Accueil',
            'sanctions'  => $this->sanctions,
            'categories' => $this->categories,
            'universities' => $this->universities,
            'formations' => $formations,
            'form'       => $form->createView()
        ]);

    }
}

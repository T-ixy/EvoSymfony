<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Functions\Construct;
use App\Model\SearchData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CguController extends Construct
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response
    {

        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formations = $this->formationRepo->findFormationsBySearch($searchData, $request);
            return $this->redirectToRoute('app_home', ['formationSearch' => http_build_query($searchData)]);
        }

        return $this->render('cgu/index.html.twig', [
            'Page_title'   => "Contacter-nous",
            'universities' => $this->universities,
            'sanctions'    => $this->sanctions,
            'categories'   => $this->categories,
            'form'         => $form->createView()
        ]);
    }
}

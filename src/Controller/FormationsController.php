<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Functions\Construct;
use App\Model\SearchData;
use App\Repository\FormationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationsController extends Construct
{
    #[Route('/formations/{id}', name: 'app_formations')]
    public function index(int $id, Request $request): Response
    {
        $formation = $this->formationRepo->findOneBy(['id' => $id]);

        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formations = $this->formationRepo->findFormationsBySearch($searchData, $request);
            return $this->redirectToRoute('app_home', ['formationSearch' => http_build_query($searchData)]);
        }

        return $this->render('formations/index.html.twig', [
            'Page_title'   => $formation->getTitle(),
            'universities' => $this->universities,
            'sanctions'    => $this->sanctions,
            'formation'    => $formation,
            'categories'   => $this->categories,
            'form'         => $form->createView()
        ]);
    }
}

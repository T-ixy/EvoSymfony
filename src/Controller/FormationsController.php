<?php

namespace App\Controller;

use App\Repository\FormationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationsController extends AbstractController
{
    #[Route('/formations/{id}', name: 'app_formations')]
    public function index(int $id, FormationsRepository $formationRepo): Response
    {
        $formation = $formationRepo->findOneBy(['id' => $id]);

        return $this->render('formations/index.html.twig', [
            'Page_title' => 'Accueil',
            'formation'  => $formation
        ]);
    }
}

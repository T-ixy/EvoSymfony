<?php

namespace App\Controller;

use App\Functions\Construct;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends Construct
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        $users = $this->users;
        return $this->render('profil/index.html.twig', [
            'Page_title' => 'User',
            'users' => $users
        ]);
    }
}

<?php

namespace App\Controller;

use App\Functions\Construct;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Construct
{

    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {

        $formations = $this->formationRepo->findAll();

        return $this->render('admin/index.html.twig', [
            'Page_title' => "Admin ~ Formations",
            'formations' => $formations
        ]);
    }

    #[Route('/admin/formation/add', name: 'app_admin_formation')]
    public function formationAdd(): Response
    {

        return $this->render('admin/formationAdd.html.twig', [
            'Page_title' => "Admin ~ Ajout de formation"
        ]);
    }

    #[Route('/profil', name: 'app_profil')]
    public function profil(): Response
    {
        return $this->render('admin/profil.html.twig', [
            'Page_title' => "Admin ~ Profil",
        ]);
    }

    #[Route('/admin/delete/{data}/{id}', name: 'app_delete')]
    public function delete(int $id, string $data, EntityManagerInterface $manager)
    {
        switch ($data) {
            case 'formation':
                $formation = $this->formationRepo->find($id);

                $manager->remove($formation);
                $manager->flush();

                return $this->redirectToRoute('app_admin');
                
                break;
        }
    }
}

<?php

namespace App\Controller;

use App\Entity\Formations;
use App\Form\FormationsType;
use App\Functions\Construct;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
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
    public function formationAdd(Request $request, EntityManagerInterface $manager): Response
    {
        $formation = new Formations();

        $formationForm = $this->createForm(FormationsType::class, $formation);
        $formationForm->handleRequest($request);

        if ($formationForm->isSubmitted() && $formationForm->isValid()) {
            $file = $formationForm->get('vignette_url')->getData();
            $uni = $formationForm->get('university')->getData();
            $filename = $file->getClientOriginalName();
            $url = $this->getParameter('formations_directory') . '/' . $uni->getuniversity() . '/' . $filename;

            $formation->setVignetteUrl($url);

            $manager->persist($formation);
            $manager->flush();

            if ($file instanceof UploadedFile) {
                $file->move(
                    $this->getParameter('formations_directory') . '/' . $uni->getuniversity(),
                    $filename
                );
            }
            return $this->redirectToRoute('app_admin');

        }

        return $this->render('admin/formationAdd.html.twig', [
            'Page_title' => "Admin ~ Ajout de formation",
            'formationForm' => $formationForm->createView()
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

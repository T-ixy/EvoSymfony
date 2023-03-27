<?php

namespace App\Controller\Admin;

use App\Entity\Formations;
use App\Form\FormationsType;
use App\Functions\Construct;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminFormationsController extends Construct
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {

        $formations = $this->formationRepo->findAll();

        return $this->render('admin/admin_formation/index.html.twig', [
            'Page_title' => "Admin ~ Formations",
            'formations' => $formations
        ]);
    }

    #[Route('/admin/formation/add', name: 'app_admin_formation')]
    #[Route('/admin/formation/update/{id}', name: 'app_admin_formationUp')]
    public function formationAdd(Request $request, EntityManagerInterface $manager, ?int $id = null): Response
    {

        if ($id) {
            $formation = $this->formationRepo->find($id);

            if (!$formation) {
                throw new Exception('Aucune formation selectionner', 1);
            }
        } else {
            $formation = new Formations();
        }

        $formation->setVignetteUrl('');
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

        return $this->render('admin/admin_formation/formationAdd.html.twig', [
            'Page_title' => "Admin ~ Ajout de formation",
            'formationForm' => $formationForm->createView()
        ]);
    }

    
}

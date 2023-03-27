<?php

namespace App\Controller\Admin;

use App\Entity\Universities;
use App\Form\UniversitiesFormType;
use App\Functions\Construct;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUniversitiesController extends Construct
{
    #[Route('/admin/universities', name: 'app_admin_universities')]
    public function index(): Response
    {

        $universities = $this->universities;

        return $this->render('admin/admin_universities/index.html.twig', [
            'Page_title' => "Admin ~ Universities",
            'universities' => $universities
        ]);
    }

    #[Route('/admin/universities/Add', name: 'app_admin_universitiesAdd')]
    #[Route('/admin/universities/Update/{id}', name: 'app_admin_universitiesUp')]
    public function universitiesAdd(Request $request, EntityManagerInterface $manager, ?int $id = null): Response
    {

        if ($id) {
            $university = $this->universityRepo->find($id);

            if (!$university) {
                throw new Exception('Aucune formation selectionner', 1);
            }
        } else{
            $university = new Universities();
        }

        $university->setLogoUrl('');
        $universitiesForm = $this->createForm(UniversitiesFormType::class, $university);
        $universitiesForm->handleRequest($request);

        if ($universitiesForm->isSubmitted() && $universitiesForm->isValid()) {
            $file = $universitiesForm->get('logo_url')->getData();
            $filename = $file->getClientOriginalName();
            
            $url = $this->getParameter('universities_directory') . '/' . $filename;

            // dd($url);

            $university->setLogoUrl($url);

            $manager->persist($university);
            $manager->flush();

            if ($file instanceof UploadedFile) {
                $file->move(
                    $this->getParameter('universities_directory'),
                    $filename
                );
            }

            return $this->redirectToRoute('app_admin_universities');
        }

        return $this->render('admin/admin_universities/universitiesAdd.html.twig', [
            'Page_title' => 'Admin ~ Ajout d\'université',
            'universitiesForm' => $universitiesForm->createView()
        ]);
    }
}

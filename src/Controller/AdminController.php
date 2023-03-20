<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Formations;
use App\Form\CategoriesType;
use App\Form\FormationsType;
use App\Functions\Construct;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
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

        return $this->render('admin/formationAdd.html.twig', [
            'Page_title' => "Admin ~ Ajout de formation",
            'formationForm' => $formationForm->createView()
        ]);
    }

    #[Route('/admin/categories', name: 'app_admin_categories')]
    public function categories(): Response
    {

        $categories = $this->categories;

        return $this->render('admin/categories.html.twig', [
            'Page_title' => "Admin ~ categories",
            'categories' => $categories
        ]);
    }

    #[Route('/admin/categories/Add', name: 'app_admin_categoriesAdd')]
    #[Route('/admin/categories/Update/{id}', name: 'app_admin_categoriesUp')]
    public function categoriesAdd(Request $request, EntityManagerInterface $manager, ?int $id = null): response
    {
        if ($id) {
            $category = $this->categoryRepo->find($id);
        } else{
            $category = new Categories();
        }

        $categoryForm = $this->createForm(CategoriesType::class, $category);
        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('app_admin_categories');
        }

        return $this->render('admin/categoryAdd.html.twig', [
            'Page_title' => "Admin ~ Ajout de categories",
            'categoryForm' => $categoryForm->createView()
        ]);
    }

    #[Route('/admin/delete/{data}/{id}', name: 'app_delete')]
    public function delete(int $id, string $data, EntityManagerInterface $manager)
    {
        switch ($data) {
            case 'formations':
                $formation = $this->formationRepo->find($id);

                $manager->remove($formation);
                $manager->flush();

                return $this->redirectToRoute('app_admin');

                break;

            case 'categories':
                $category = $this->categoryRepo->find($id);

                $manager->remove($category);
                $manager->flush();

                return $this->redirectToRoute('app_admin_categories');

                break;
        }
    }
}

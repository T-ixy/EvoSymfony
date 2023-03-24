<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Functions\Construct;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesAdminController extends Construct
{
    #[Route('/admin/categories', name: 'app_admin_categories')]
    public function index(): Response
    {

        $categories = $this->categories;

        return $this->render('categories_admin/index.html.twig', [
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

        return $this->render('categories_admin/categoryAdd.html.twig', [
            'Page_title' => "Admin ~ Ajout de categories",
            'categoryForm' => $categoryForm->createView()
        ]);
    }
}

<?php

namespace App\Functions;
use App\Repository\CategoriesRepository;
use App\Repository\FormationsRepository;
use App\Repository\SanctionsRepository;
use App\Repository\UniversitiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Construct extends AbstractController
{
    /**
     * @var SanctionsRepository
     */
    protected SanctionsRepository $sanctionRepo;

    /**
     * @var CategoriesRepository
     */
    protected CategoriesRepository $categoryRepo;

    /**
     * @var FormationsRepository
     */
    protected FormationsRepository $formationRepo;

    /**
     * @var UniversitiesRepository
     */
    protected UniversitiesRepository $universityRepo;

    /**
     * @var array
     */
    protected array $universities;

    /**
     * @var array
     */
    protected array $sanctions;

    /**
     * @var array
     */
    protected array $categories;

    public function __construct(
        SanctionsRepository $sanctionRepo, 
        CategoriesRepository $categoryRepo, 
        FormationsRepository $formationRepo, 
        UniversitiesRepository $universityRepo
        ) 
    {
        $this->sanctionRepo = $sanctionRepo;
        $this->categoryRepo = $categoryRepo;
        $this->formationRepo = $formationRepo;
        $this->universityRepo = $universityRepo;

        $this->universities = $this->universityRepo->findAll();
        $this->sanctions = $this->sanctionRepo->findAll();
        $this->categories = $this->categoryRepo->findAll();
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

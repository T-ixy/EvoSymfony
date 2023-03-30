<?php

namespace App\Controller\Admin;

use App\Entity\Sanctions;
use App\Form\SanctionFormType;
use App\Functions\Construct;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminSanctionController extends Construct
{
    #[Route('/admin/sanction', name: 'app_admin_sanction')]
    public function index(Request $request, EntityManagerInterface $manager): Response
    {

        $sanction = new Sanctions();

        $sanctions = $this->sanctions;

        $sanctionForm = $this->createForm(SanctionFormType::class, $sanction);
        $sanctionForm->handleRequest($request);

        if ($sanctionForm->isSubmitted() && $sanctionForm->isValid()) {
            $manager->persist($sanction);
            $manager->flush();

            return $this->redirectToRoute('app_admin_sanction');
        }

        return $this->render('admin/admin_sanction/index.html.twig', [
            'Page_title' => 'Admin ~ Sanction',
            'sanctions' => $sanctions,
            'sanctionForm' => $sanctionForm->createView()
        ]);
    }
}

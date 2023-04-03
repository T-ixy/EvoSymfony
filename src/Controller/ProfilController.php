<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Functions\Construct;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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

    #[Route('/profil/Add', name: 'app_profil_add')]
    #[Route('/profil/Update/{id}', name: 'app_profil_update')]
    public function userAdd(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher, ?int $id = null): Response
    {

        if ($id) {
            $user = $this->userRepo->find($id);
        } else{
            $user = new User();
        }

        $userForm = $this->createForm(UserFormType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $role = $userForm->get('roles')->getData();
            $pass = $userForm->get('password')->getData();
            $pass = $passwordHasher->hashPassword($user, $pass);

            $user->setRoles($role)
                ->setPassword($pass);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_profil');
        }

        return $this->render('profil/add.html.twig', [
            'Page_title' => 'Ajouter',
            'userForm' => $userForm->createView()
        ]);
    }
}

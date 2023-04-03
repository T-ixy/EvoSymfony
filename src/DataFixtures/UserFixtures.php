<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordhasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher) {
        $this->passwordhasher = $passwordHasher;
    }


    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setEmail('nantenaina.cav@gmail.com')
            ->setPassword($this->passwordhasher->hashPassword($user, 'Shiranai1401'))
            ->setRoles(["ROLE_ADMIN"])
            ->setName("RABESAHALA Tiana");
        $manager->persist($user);

        $manager->flush();
    }
}

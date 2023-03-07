<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Formations;
use App\Entity\Sanctions;
use App\Entity\Universities;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = \Faker\Factory::create('fr_FR');
        $cats = [];
        for ($i = 0; $i < 15; $i++) {
            $cat = new Categories();

            $cat->setCategory($faker->word())
                ->setIconeUrl($faker->imageUrl(640, 480, 'font-awesome', true))
                ->setColor($faker->hexColor());

            $manager->persist($cat);
            $cats[] = $cat;
        }

        $sancs = [];
        for ($i=0; $i < 5; $i++) { 
            $sanc = new Sanctions();

            $sanc->setSanction($faker->word());

            $manager->persist($sanc);
            $sancs[] = $sanc;
        }

        $unis = [];
        for ($i=0; $i < 10; $i++) { 
            $uni = new Universities();

            $uni->setUniversity($faker->words(3, true))
                ->setLogoUrl($faker->imageUrl(640, 480, 'university', true))
                ->setLoginUrl($faker->url())
                ->setSiteUrl($faker->url());

            $manager->persist($uni);
            $unis[] = $uni;
        }

        for ($i=0; $i < 20; $i++) { 
            $for = new Formations();

            $for->setSanction($sancs[rand(0,4)])
                ->setUniversity($unis[rand(0,9)])
                ->setTitle($faker->words(5, true))
                ->setGenerality($faker->paragraphs(6, true))
                ->setPrerequisite($faker->words(3, true))
                ->setPurpose($faker->words(5, true))
                ->setFinality($faker->sentence(5))
                ->setContents($faker->paragraphs(6, true))
                ->setPrices($faker->randomNumber(5, true))
                ->setDuration($faker->word())
                ->setPriority($faker->boolean())
                ->setVignetteUrl($faker->imageUrl(640, 480, 'formation', true));

            $randomCategories = array_rand($cats, rand(2, 3));
            foreach ($randomCategories as $index) {
                $category = $cats[$index];
                $for->addCategory($category);
            }

                $manager->persist($for);
        }

        $manager->flush();
    }
}

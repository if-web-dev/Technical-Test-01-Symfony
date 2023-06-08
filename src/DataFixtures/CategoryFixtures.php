<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\CarCategory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class CategoryFixtures extends Fixture
{
    public const CATEGORY_REFERENCE = 'category';

    public function load(ObjectManager $manager): void
    {
      
        $faker = Factory::create();
        $faker->seed(1234);

        for ($i = 0; $i < 5; $i++) {
            $category = (new CarCategory())
                ->setName($faker->unique()->word);
    
            $manager->persist($category);
    
            $this->addReference(self::CATEGORY_REFERENCE . $i, $category);
        }

        $manager->flush();
    }
}

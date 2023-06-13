<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Car;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CarFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $faker->addProvider(new \Faker\Provider\Fakecar($faker));
        $faker->seed(1234);

        for ($i = 0; $i < 100; $i++) {


            $category = $this->getReference(CategoryFixtures::CATEGORY_REFERENCE . rand(0, 4));

            $car = (new Car())
                ->setCarCategory($category)
                ->setName($faker->vehicle)
                ->setNbDoors($faker->randomElement([3, 4, 5]))
                ->setNbSeats($faker->randomElement([2, 5, 7]))
                ->setCost($faker->numberBetween(10000, 50000));

            $manager->persist($car);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class
        ];
    }
}

<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

use App\Entity\User;

class DataFixtures extends Fixture
{

    /**
     * DataFixtures constructor.
     */
    public function __construct()
    {
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for($i = 0; $i < 100; $i++)
        {
        $user = new User();

        $user->setEmail($faker->email());
        $user->setPassword(rand(1,100000000));
        $user->setRoles(['ROLE_USER']);
        $user->setFirstName($faker->firstName($gender = null));
        $user->setLastName($faker->lastName());

        $manager->persist($user);
        $manager->flush();
        }
    }
}
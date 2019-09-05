<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture //standard AppFixture practice class
{
    public function load(ObjectManager $manager)
    {
        $manager->flush();
    }
}

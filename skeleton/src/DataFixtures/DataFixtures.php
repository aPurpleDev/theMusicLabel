<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Faker;

use App\Entity\User;

class DataFixtures extends Fixture
{
    private $passwordEncoder;

    /**
     * DataFixtures constructor.
     * @param $passwordEncoder
     */
    public function __construct(PasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        $user = new User();

        $user->setEmail();
        $user->setPassword();
        $user->setRoles('ROLE_USER');
    }
}
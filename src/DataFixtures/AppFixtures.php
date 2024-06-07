<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('el@gmail.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPlainPassword('password');


        
        $manager->persist($user);

        $manager->flush();
    }
}

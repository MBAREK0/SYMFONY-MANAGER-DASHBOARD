<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('mbarekelaadraoui@gmail.com');
        $user->setRoles(['ROLE_OWNER']);
        $password = $this->hasher->hashPassword(
            $user,
           'password'
        );
        $user->setPassword($password);


        
        $manager->persist($user);

        $manager->flush();
    }
}

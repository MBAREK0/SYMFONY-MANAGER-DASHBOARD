<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\PersonalInformation;
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

        $owner = new User();
        $owner->setEmail($_ENV['OWNER_EMAIL']);
        $owner->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $password = $this->hasher->hashPassword(
            $owner,
            $_ENV['OWNER_PASSWORD']
        );
        $owner->setPassword($password);
        $manager->persist($owner);


        $manager->flush();
    }
}

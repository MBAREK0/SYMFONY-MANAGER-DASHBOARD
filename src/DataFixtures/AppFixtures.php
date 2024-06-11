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
        $owner = new User();
        $owner->setEmail($_ENV['OWNER_EMAIL']);
        $owner->setRoles(['ROLE_OWNER']);
        $password = $this->hasher->hashPassword(
            $owner,
            $_ENV['OWNER_PASSWORD']
        );
        $owner->setPassword($password);
        $manager->persist($owner);


        $user = new User();
        $user->setEmail($_ENV['GUEST_EMAIL']);
        $user->setRoles(['ROLE_USER']);
        $password = $this->hasher->hashPassword(
            $user,
            $_ENV['GUEST_PASSWORD']
        );
        $user->setPassword($password);
        $manager->persist($user);


        $manager->flush();
    }
}

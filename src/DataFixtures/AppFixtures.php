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
        $owner->setEmail('mbarekelaadraoui@gmail.com');
        $owner->setRoles(['ROLE_OWNER']);
        $password = $this->hasher->hashPassword(
            $owner,
            'owner'
        );
        $owner->setPassword($password);
        $manager->persist($owner);


        $user = new User();
        $user->setEmail('user@porto.com');
        $user->setRoles(['ROLE_USER']);
        $password = $this->hasher->hashPassword(
            $user,
            'user'
        );
        $user->setPassword($password);
        $manager->persist($user);


        $manager->flush();
    }
}

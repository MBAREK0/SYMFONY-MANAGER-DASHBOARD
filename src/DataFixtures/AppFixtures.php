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
        // $PersonalInformation = new PersonalInformation();
        // $PersonalInformation->setFirstName('John');
        // $PersonalInformation->setLastName('Doe');
        // $PersonalInformation->setNickName('JD');
        // $PersonalInformation->setAbout('I am a software engineer');
        // $PersonalInformation->setPosition('Software Engineer');
        // $manager->persist($PersonalInformation);



        $owner = new User();
        $owner->setEmail($_ENV['OWNER_EMAIL']);
        $owner->setRoles(['ROLE_OWNER']);
        $password = $this->hasher->hashPassword(
            $owner,
            $_ENV['OWNER_PASSWORD']
        );
        $owner->setPassword($password);
        // $owner->setPersonalInformation($PersonalInformation);
        $manager->persist($owner);


        $user = new User();
        $user->setEmail($_ENV['GUEST_EMAIL']);
        $user->setRoles(['ROLE_USER']);
        $password = $this->hasher->hashPassword(
            $user,
            $_ENV['GUEST_PASSWORD']
        );
        $user->setPassword($password);
        // $user->setPersonalInformation(null);
        $manager->persist($user);


        $manager->flush();
    }
}

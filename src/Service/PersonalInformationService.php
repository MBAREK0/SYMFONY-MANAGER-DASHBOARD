<?php

namespace App\Service;

use App\Entity\PersonalInformation;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PersonalInformationRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PersonalInformationService
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }
    

    public function getInfo(): object
    {
        $personalInformation = $this->entityManager->getRepository(PersonalInformation::class)->findOneBy([]);
        if (!$personalInformation)  return [];
        return $personalInformation;
    }

    public function create(array $data): PersonalInformation
    {
        $personalInfo = new PersonalInformation();
       
        $personalInfo->setFirstName($request->get('firstName'));
        $personalInfo->setLastName($request->get('lastName'));
        $personalInfo->setNickName($request->get('nickName'));
        $personalInfo->setAbout($request->get('about'));
        $personalInfo->setEmail($request->get('email'));
        
        // Hash the password before setting it
        $password = $request->get('password');
        if ($password) {
            $hashedPassword = $passwordEncoder->encodePassword($personalInfo, $password);
            $personalInfo->setPassword($hashedPassword);
        }
    
        $this->entityManager->persist($personalInfo);
        $this->entityManager->flush();
    
        return $personalInfo;
    }


    public function updateInfo(int $id, Request $request, UserPasswordEncoderInterface $passwordEncoder): PersonalInformation
    {
        $personalInfo = $this->entityManager->getRepository(PersonalInformation::class)->find($id);
        if (!$personalInfo) {
            throw new PersonalInformationNotFoundException('Personal Information not found.');
        }
    
        $personalInfo->setFirstName($request->get('firstName'));
        $personalInfo->setLastName($request->get('lastName'));
        $personalInfo->setNickName($request->get('nickName'));
        $personalInfo->setAbout($request->get('about'));
        $personalInfo->setEmail($request->get('email'));
        
        // Hash the password before setting it
        $password = $request->get('password');
        if ($password) {
            $hashedPassword = $passwordEncoder->encodePassword($personalInfo, $password);
            $personalInfo->setPassword($hashedPassword);
        }
    
        $this->entityManager->flush();
    
        return $personalInfo;
    }

}
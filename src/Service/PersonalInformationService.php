<?php

namespace App\Service;

use App\Entity\PersonalInformation;
use Doctrine\ORM\EntityManagerInterface;
use stdClass;

class PersonalInformationService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    public function getInfo(): ?object
    {
        $personalInformation = $this->entityManager->getRepository(PersonalInformation::class)->findOneBy([]);

        if (!$personalInformation) {
            return new stdClass();
        }

        return $personalInformation;
    }


    public function createInfo(object $request): PersonalInformation
    {
        $session = $request->getSession();
        $sesstion_csrf_token = $session->get('csrf_token');

        if ($sesstion_csrf_token != $request->get('csrf_token')) {
            throw new \Exception('Invalid CSRF token');
        }

        $personalInfo = new PersonalInformation();

        $personalInfo->setFirstName($request->get('firstName'));
        $personalInfo->setLastName($request->get('lastName'));
        $personalInfo->setNickName($request->get('nickName'));
        $personalInfo->setAbout($request->get('about'));
        $personalInfo->setPosition($request->get('position'));


        $this->entityManager->persist($personalInfo);
        $this->entityManager->flush();

        return $personalInfo;
    }


    public function updateInfo(int $id, object $request): PersonalInformation
    {
        $session = $request->getSession();
        $sesstion_csrf_token = $session->get('csrf_token');

        if ($sesstion_csrf_token != $request->get('csrf_token')) {
            throw new \Exception('Invalid CSRF token');
        }

        $personalInfo = $this->entityManager->getRepository(PersonalInformation::class)->find($id);
        if (!$personalInfo) {
            throw new PersonalInformationNotFoundException('Personal Information not found.');
        }

        $personalInfo->setFirstName($request->get('firstName'));
        $personalInfo->setLastName($request->get('lastName'));
        $personalInfo->setNickName($request->get('nickName'));
        $personalInfo->setAbout($request->get('about'));
        $personalInfo->setPosition($request->get('position'));


        $this->entityManager->flush();

        return $personalInfo;
    }
}

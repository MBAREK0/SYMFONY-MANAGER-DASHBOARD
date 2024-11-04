<?php

namespace App\Service;

use App\Entity\PersonalInformation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use stdClass;

class PersonalInformationService
{
    private $entityManager;
    private $user;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $em;
        $token = $tokenStorage->getToken();

        if ($token) {
            if ($token->getUser() && is_object($token->getUser())) {
                $this->user = $token->getUser();
            } else {
                throw new \Exception('User not found');
            }
        }
    }

    public function getInfo(): ?object
    {
        $personalInformation = $this->user->getPersonalInformation();

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

        $personalInfo->setFirstName($request->get('firstName'))
                         ->setLastName($request->get('lastName'))
                         ->setNickName($request->get('nickName'))
                         ->setAboutEn($request->get('about_en'))
                         ->setAboutFr($request->get('about_fr'))
                         ->setPositionEn($request->get('position_en'))
                         ->setPositionFr($request->get('position_fr'))
                         ->setCurrentRoleEn($request->get('current_role_en'))
                         ->setCurrentRoleFr($request->get('current_role_fr'))
                         ->setPresentationEn($request->get('presentation_en'))
                         ->setPresentationFr($request->get('presentation_fr'));



        $this->entityManager->persist($this->user->setPersonalInformation($personalInfo));
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


        $personalInfo->setFirstName($request->get('firstName'))
                     ->setLastName($request->get('lastName'))
                     ->setNickName($request->get('nickName'))
                     ->setAboutEn($request->get('about_en'))
                     ->setAboutFr($request->get('about_fr'))
                     ->setPositionEn($request->get('position_en'))
                     ->setPositionFr($request->get('position_fr'))
                     ->setCurrentRoleEn($request->get('current_role_en'))
                     ->setCurrentRoleFr($request->get('current_role_fr'))
                     ->setPresentationEn($request->get('presentation_en'))
                     ->setPresentationFr($request->get('presentation_fr'));


        $this->entityManager->flush();


        return $personalInfo;
    }
}

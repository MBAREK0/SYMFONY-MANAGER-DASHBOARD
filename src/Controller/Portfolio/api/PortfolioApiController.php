<?php

namespace App\Controller\Portfolio\api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\PersonalInformationRepository;
use App\Repository\AwardRepository;
use App\Repository\ExperienceRepository;
use App\Repository\ProjectRepository;
use App\Repository\SkillRepository;
use App\Repository\LicenseAndCertificationRepository;
use App\Repository\EducationRepository;
use App\Repository\MediaRepository;
use App\Repository\UserRepository;

class PortfolioApiController extends AbstractController
{
    private $personalInformationRepository;
    private $awardRepository;
    private $experienceRepository;
    private $projectRepository;
    private $skillRepository;
    private $licenseAndCertificationRepository;
    private $educationRepository;
    private $mediaRepository;
    private $userRepository;

    public function __construct(
        PersonalInformationRepository $personalInformationRepository,
        AwardRepository $awardRepository,
        ExperienceRepository $experienceRepository,
        ProjectRepository $projectRepository,
        SkillRepository $skillRepository,
        LicenseAndCertificationRepository $licenseAndCertificationRepository,
        EducationRepository $educationRepository,
        MediaRepository $mediaRepository,
        UserRepository $userRepository
    ) {
        $this->personalInformationRepository = $personalInformationRepository;
        $this->awardRepository = $awardRepository;
        $this->experienceRepository = $experienceRepository;
        $this->projectRepository = $projectRepository;
        $this->skillRepository = $skillRepository;
        $this->licenseAndCertificationRepository = $licenseAndCertificationRepository;
        $this->educationRepository = $educationRepository;
        $this->mediaRepository = $mediaRepository;
        $this->userRepository = $userRepository;
    }

    #[Route('/api/portfolio/{email}', name: 'app_api_portfolio')]
    public function index(string $email): Response
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);
        

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }


        return $this->json([
            'personalInformation'      => $this->getPersonalInformation($user),
            'media'                    => $this->getMedia($user),
            'educations'               => $this->getEducations($user),
            'licenseAndCertifications' => $this->getLicenseAndCertifications($user),
            'skills'                   => $this->getSkills($user),
            'projects'                 => $this->getProjects($user),
            'experiences'              => $this->getExperiences($user),
            'awards'                   => $this->getAwards($user),
            'languages'                => $this->getLanguages($user),     
            
        ]);
    }

    public function getMedia($user)
    {
        $mediaArray = [];
        $media = $this->mediaRepository->findMediaByUserDesc($user);


        foreach ($media as $m) {
            $mediaArray[] = [
                'id'      => $m->getId(),
                'name'    => $m->getName(),
                'path'    => $m->getPath(),
                'contact' => $m->getContact(),
            ];
        }


        return $mediaArray;
    }

    public function getPersonalInformation($user)
    {
        $personalInformation = $user->getPersonalInformation();

        return $personalInformation->getId() ? [
            'id'        => $personalInformation->getId(),
            'firstName' => $personalInformation->getFirstName(),
            'lastName'  => $personalInformation->getLastName(),
            'nickName'  => $personalInformation->getNickName(),
            'about'     => $personalInformation->getAbout(),
            'position'  => $personalInformation->getPosition(),
        ] : [];
    }

    public function getAwards($user)
    {
        $awardsArray = [];
        $awards = $this->awardRepository->findAwardsByUserDesc($user);

        foreach ($awards as $award) {
            $awardsArray[] = [
                'id'          => $award->getId(),
                'title'       => $award->getTitle(),
                'description' => $award->getDescription(),
                'date'        => $award->getDate(),
            ];
        }

        return $awardsArray;
    }

    public function getExperiences($user)
    {
        $experiencesArray = [];
        $experiences = $this->experienceRepository->findExperiencesByUserDesc($user);

        foreach ($experiences as $experience) {
            $technologies = [];
            foreach ($experience->getTechnologiesUsed() as $technology) {
                $technologies[] = $technology->getName();
            };
            $experiencesArray[] = [
                'id'                => $experience->getId(),
                'organization'      => $experience->getOrganization(),
                'role'              => $experience->getRole(),
                'start_date'        => $experience->getStartDate(),
                'end_date'          => $experience->getEndDate(),
                'responsibilities'  => $experience->getResponsibilities(),
                'achievements'      => $experience->getAchievements(),
                'imageName'         => $experience->getImageName(),
                'technologies_used' => $technologies,
            ];
        }

        return $experiencesArray;
    }

    public function getProjects($user)
    {
        $projectsArray = [];
        $projects = $this->projectRepository->findProjectsByUserDesc($user);

        foreach ($projects as $project) {
            $technologies = [];
            foreach ($project->getTechnologies() as $technology) {
                $technologies[] = $technology->getName();
            };

            $projectsArray[] = [
                'id'           => $project->getId(),
                'name'         => $project->getName(),
                'github_path'  => $project->getGithubPath(),
                'host_path'    => $project->getHostPath(),
                'description'  => $project->getDescription(),
                'imageName'    => $project->getImageName(),
                'technologies' => $technologies,
            ];
        }

        return $projectsArray;
    }

    public function getSkills($user)
    {
        $skillsArray = [];
        $skills = $user->getSkills();

        foreach ($skills as $skill) {
            $skillsArray[] = [
                'id'   => $skill->getId(),
                'name' => $skill->getName(),

            ];
        }

        return $skillsArray;
    }

    public function getLicenseAndCertifications($user)
    {
        $licenseAndCertificationsArray = [];
        $licenseAndCertifications = $this->licenseAndCertificationRepository->findLicenseAndCertificationByUserDesc($user);


        foreach ($licenseAndCertifications as $licenseAndCertification) {
            $skills = [];
            foreach ($licenseAndCertification->getSkills() as $skill) {
                $skills[] = $skill->getName();
            };

            $licenseAndCertificationsArray[] = [
                'id'           => $licenseAndCertification->getId(),
                'name'         => $licenseAndCertification->getName(),
                'organization' => $licenseAndCertification->getOrganization(),
                'date'         => $licenseAndCertification->getDate(),
                'description'  => $licenseAndCertification->getDescription(),
                'imageName'    => $licenseAndCertification->getImageName(),
                'skills'       => $skills,

            ];
        }

        return $licenseAndCertificationsArray;
    }

    public function getEducations($user)
    {
        $educationsArray = [];
        $educations = $this->educationRepository->findEducationsByUserDesc($user);

        foreach ($educations as $education) {
            $skills = [];
            foreach ($education->getSkills() as $skill) {
                $skills[] = $skill->getName();
            };

            $educationsArray[] = [
                'id'          => $education->getId(),
                'school'      => $education->getSchool(),
                'degree'      => $education->getDegree(),
                'specialty'   => $education->getSpecialty(),
                'start_date'  => $education->getStartDate(),
                'end_date'    => $education->getEndDate(),
                'grade'       => $education->getGrade(),
                'description' => $education->getDescription(),
                'imageName'   => $education->getImageName(),
                'skills'      => $skills,
            ];
        }

        return $educationsArray;
    }

    public function getLanguages($user)
    {
        $languagesArray = [];
        $languages = $user->getLanguages();

        foreach ($languages as $language) {
            $languagesArray[] = [
                'id'          => $language->getId(),
                'name'        => $language->getName(),
                'proficiency' => $language->getProficiency(),
            ];
        }

        return $languagesArray;
    }
}

<?php

namespace App\Controller\Portfolio\api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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

    #[Route('/api/portfolio/info/{email}')]
    public function getPersonalInformation(string $email, Request $request)
    {
        $lang = $request->query->get('lang', 'en');
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }


        $personalInformation = $user->getPersonalInformation();

        if (!$personalInformation) {
            return new JsonResponse(['error' => 'No personal information found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json([
        'status'  => 'success',
        'data'    => [
            'id'          => $personalInformation->getId(),
            'firstName'   => $personalInformation->getFirstName(),
            'lastName'    => $personalInformation->getLastName(),
            'nickName'    => $personalInformation->getNickName(),
            'about'       => $personalInformation->{'getAbout' . ucfirst($lang)}(),
            'position'    => $personalInformation->{'getPosition' . ucfirst($lang)}(),
            'currentRole' => $personalInformation->{'getCurrentRole' . ucfirst($lang)}(),
        ]], 200);
    }

    #[Route('/api/portfolio/educations/{email}')]
    public function getEducations(string $email, Request $request)
    {
        $lang = $request->query->get('lang', 'en');
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $educationsArray = [];
        $educations = $this->educationRepository->findEducationsByUserDesc($user);

        if (!$educations) {
            return new JsonResponse(['error' => 'No educations found'], Response::HTTP_NOT_FOUND);
        }

        foreach ($educations as $education) {
            $skills = [];
            foreach ($education->getSkills() as $skill) {
                $skills[] = $skill->getName();
            };

            $educationsArray[] = [
                'id'          => $education->getId(),
                'school'      => $education->getSchool(),
                'degree'      => $education->{'getDegree' . ucfirst($lang)}(),
                'specialty'   => $education->{'getSpecialty' . ucfirst($lang)}(),
                'start_date'  => $education->getStartDate(),
                'end_date'    => $education->getEndDate(),
                'description' => $education->{'getDescription' . ucfirst($lang)}(),
                'imageName'   => $education->getImageName(),
                'skills'      => $skills,
            ];
        }

        return $this->json([
            'status'  => 'success',
            'data'    => $educationsArray,
        ], 200);
    }

    #[Route('/api/portfolio/contacts/{email}')]
    public function getMedia(string $email)
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);


        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }


        $mediaArray = [];
        $media = $this->mediaRepository->findMediaByUserDesc($user);

        if (!$media) {
            return new JsonResponse(['error' => 'No contacts found'], Response::HTTP_NOT_FOUND);
        }


        foreach ($media as $m) {
            $mediaArray[] = [
                'id'      => $m->getId(),
                'name'    => $m->getName(),
                'path'    => $m->getPath(),
                'contact' => $m->getContact(),
                'ImageName'   => $m->getImageName(),
            ];
        }


        return $this->json([
            'status'  => 'success',
            'data'    => $mediaArray,
        ], 200);
    }

    #[Route('/api/portfolio/awards/{email}')]
    public function getAwards(string $email, Request $request)
    {
        $lang = $request->query->get('lang', 'en');
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }


        $awardsArray = [];
        $awards = $this->awardRepository->findAwardsByUserDesc($user);

        if (!$awards) {
            return new JsonResponse(['error' => 'No awards found'], Response::HTTP_NOT_FOUND);
        }

        foreach ($awards as $award) {
            $awardsArray[] = [
                'id'          => $award->getId(),
                'title'       => $award->{'getTitle' . ucfirst($lang)}(),
                'issuingOrganization' => $award->{'getIssuingOrganization' . ucfirst($lang)}(),
                'description' => $award->{'getDescription' . ucfirst($lang)}(),
                'date'        => $award->getDate(),
                'imageName'   => $award->getImageName(),
            ];
        }

        return $this->json([
            'status'  => 'success',
            'data'    => $awardsArray,
        ], 200);
    }

    #[Route('/api/portfolio/experiences/{email}')]
    public function getExperiences(string $email, Request $request)
    {
        $lang = $request->query->get('lang', 'en');
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $experiencesArray = [];
        $experiences = $this->experienceRepository->findExperiencesByUserDesc($user);

        if (!$experiences) {
            return new JsonResponse(['error' => 'No experiences found'], Response::HTTP_NOT_FOUND);
        }

        foreach ($experiences as $experience) {
            $technologies = [];
            foreach ($experience->getTechnologiesUsed() as $technology) {
                $technologies[] = $technology->getName();
            };
            $experiencesArray[] = [
                'id'                => $experience->getId(),
                'organization'      => $experience->getOrganization(),
                'role'              => $experience->{'getRole' . ucfirst($lang)}(),
                'start_date'        => $experience->getStartDate(),
                'end_date'          => $experience->getEndDate(),
                'responsibilities'  => $experience->{'getResponsibilities' . ucfirst($lang)}(),
                'achievements'      => $experience->{'getAchievements' . ucfirst($lang)}(),
                'imageName'         => $experience->getImageName(),
                'technologies_used' => $technologies,
            ];
        }

        return $this->json([
            'status'  => 'success',
            'data'    => $experiencesArray,
        ], 200);
    }


    #[Route('/api/portfolio/projects/{email}')]
    public function getProjects(string $email , Request $request)
    {
        $lang = $request->query->get('lang', 'en');
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $projectsArray = [];
        $projects = $this->projectRepository->findProjectsByUserDesc($user);

        if (!$projects) {
            return new JsonResponse(['error' => 'No projects found'], Response::HTTP_NOT_FOUND);
        }

        foreach ($projects as $project) {
            $technologies = [];
            foreach ($project->getTechnologies() as $technology) {
                $technologies[] = $technology->getName();
            };

            $ProjectImages = [];
            foreach ($project->getProjectImages() as $ProjectImage) {
                $ProjectImages[] = $ProjectImage->getImageName();
            };


            $projectsArray[] = [
                'id'           => $project->getId(),
                'name'         => $project->getName(),
                'github_path'  => $project->getGithubPath(),
                'host_path'    => $project->getHostPath(),
                'description'  => $project->{'getDescription' . ucfirst($lang)}(),
                'imageName'    => $project->getImageName(),
                'technologies' => $technologies,
                'ProjectImages'    => $ProjectImages
            ];
        }

        return $this->json([
            'status'  => 'success',
            'data'    => $projectsArray,
        ], 200);
    }

    #[Route('/api/portfolio/skills/{email}')]
    public function getSkills(string $email)
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $skillsArray = [];
        $skills = $user->getSkills();

        if (!$skills) {
            return new JsonResponse(['error' => 'No skills found'], Response::HTTP_NOT_FOUND);
        }

        foreach ($skills as $skill) {
            $skillsArray[] = [
                'id'   => $skill->getId(),
                'name' => $skill->getName(),

            ];
        }

        return $this->json([
            'status'  => 'success',
            'data'    => $skillsArray,
        ], 200);
    }

    #[Route('/api/portfolio/licenses-and-certifications/{email}')]
    public function getLicenseAndCertifications(string $email, Request $request)
    {
        $lang = $request->query->get('lang', 'en');
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $licenseAndCertificationsArray = [];
        $licenseAndCertifications = $this->licenseAndCertificationRepository->findLicenseAndCertificationByUserDesc($user);

        if (!$licenseAndCertifications) {
            return new JsonResponse(['error' => 'No license and certifications found'], Response::HTTP_NOT_FOUND);
        }

        foreach ($licenseAndCertifications as $licenseAndCertification) {
            $skills = [];
            foreach ($licenseAndCertification->getSkills() as $skill) {
                $skills[] = $skill->getName();
            };

            $licenseAndCertificationsArray[] = [
                'id'           => $licenseAndCertification->getId(),
                'name'         => $licenseAndCertification->{'getName' . ucfirst($lang)}(),
                'organization' => $licenseAndCertification->getOrganization(),
                'date'         => $licenseAndCertification->getDate(),
                'description'  => $licenseAndCertification->{'getDescription' . ucfirst($lang)}(),
                'imageName'    => $licenseAndCertification->getImageName(),
                'skills'       => $skills,

            ];
        }

        return $this->json([
            'status'  => 'success',
            'data'    => $licenseAndCertificationsArray,
        ], 200);
    }

    #[Route('/api/portfolio/languages/{email}')]
    public function getLanguages(string $email, Request $request)
    {
        $lang = $request->query->get('lang', 'en');
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $languagesArray = [];
        $languages = $user->getLanguages();

        if (!$languages) {
            return new JsonResponse(['error' => 'No languages found'], Response::HTTP_NOT_FOUND);
        }

        foreach ($languages as $language) {
            $languagesArray[] = [
                'id'          => $language->getId(),
                'name'        => $language->{'getName' . ucfirst($lang)}(),
                'proficiency' => $language->{'getProficiency' . ucfirst($lang)}(),
            ];
        }

        return $this->json([
            'status'  => 'success',
            'data'    => $languagesArray,
        ], 200);
    }
}

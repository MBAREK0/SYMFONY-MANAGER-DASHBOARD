<?php

namespace App\Controller\Portfolio;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Experience;
use App\Form\ExperienceType;
use App\Repository\ExperienceRepository;
use App\Repository\SkillRepository;

class ExperienceController extends AbstractController
{
    private $entityManager;
    private $experienceRepository;
    private $skillRepository;


    public function __construct(
        EntityManagerInterface $em,
        ExperienceRepository $experienceRepository,
        SkillRepository $skillRepository
    ) {
        $this->entityManager = $em;
        $this->skillRepository = $skillRepository;
        $this->experienceRepository = $experienceRepository;
    }


    /**
     * ? in this Function we can add, see all the experience
     * ? @Route("/experience", name="app_experience")
     * @param Request $request
     * @return Response
     */
    #[Route('/experience', name: 'app_experience')]
    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    public function index(Request $request): Response
    {
        $experience = new Experience();

        // Assuming you have a method to fetch skills for the current user
        $skills = $this->skillRepository->findSkillsByUser($this->getUser()->getId());

        $form = $this->createForm(ExperienceType::class, $experience, [
            'skills' => $skills,
        ]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $experience->setUser($this->getUser());
                $this->entityManager->persist($experience);
                $this->entityManager->flush();
                $this->addFlash('success', 'Experience added successfully');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Unable to add experience');
            }
        }

        return $this->render('portfolio/experience/index.html.twig', [
            'form'        => $form->createView(),
            'experiences' => $this->experienceRepository->findExperiencesByUserDesc($this->getUser()),
        ]);
    }

    /**
     * ? in this Function we can edit the experience
     * ? @Route("/experience/edit/{id}", name="app_experience_edit")
     * @param Request $request
     * @param Experience $experience
     * @return Response
     */

    #[Route('/experience/edit/{id}', name: 'app_experience_edit')]
    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    public function edit(Request $request, Experience $experience): Response
    {
        if ($experience->getUser() !== $this->getUser()) {
            $this->addFlash('error', 'You are not authorized to edit this experience');

            return $this->redirectToRoute('app_experience');
        }

        $skills = $this->skillRepository->findSkillsByUser($this->getUser()->getId());

        $form = $this->createForm(ExperienceType::class, $experience, [
            'skills' => $skills,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->flush();
                $this->addFlash('success', 'Experience updated successfully');

                return $this->redirectToRoute('app_experience');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Unable to update experience');

                return $this->redirectToRoute('app_experience');
            }
        }

        return $this->render('portfolio/experience/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * ? in this Function we can delete the experience
     * ? @Route("/experience/delete/{id}", name="app_experience_delete")
     * @param Experience $experience
     * @return Response
     */



    #[Route('/experience/delete/{id}', name: 'app_experience_delete')]
    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    public function delete(Experience $experience = null): Response
    {
        if (!$experience) {
            $this->addFlash('error', 'Experience not found');

            return $this->redirectToRoute('app_experience');
        }

        if ($experience->getUser() !== $this->getUser()) {
            $this->addFlash('error', 'You are not authorized to delete this experience');

            return $this->redirectToRoute('app_experience');
        }

        try {
            $this->entityManager->remove($experience);
            $this->entityManager->flush();
            $this->addFlash('success', 'Experience deleted successfully');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Unable to delete experience');
        }

        return $this->redirectToRoute('app_experience');
    }
}

<?php

namespace App\Controller\Portfolio;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Education;
use App\Form\EducationType;
use App\Repository\EducationRepository;
use App\Repository\SkillRepository;

class EducationController extends AbstractController
{
    private $entityManager;
    private $educationRepository;
    private $skillRepository;


    public function __construct(EntityManagerInterface $em, EducationRepository $educationRepository, SkillRepository $skillRepository)
    {
        $this->entityManager = $em;
        $this->skillRepository = $skillRepository;
        $this->educationRepository = $educationRepository;
    }


    /**
     * ? in this Function we can add, see all the education
     * ? @Route("/education", name="app_education")
     * @param Request $request
     * @return Response
     */
    #[Route('/education', name: 'app_education')]
    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    public function index(Request $request): Response
    {
        $Education = new Education();

        // Assuming you have a method to fetch skills for the current user
        $skills = $this->skillRepository->findSkillsByUser($this->getUser()->getId());


        $form = $this->createForm(EducationType::class, $Education, [
            'skills' => $skills,
        ]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $Education->setUser($this->getUser());

                $this->entityManager->persist($Education);
                $this->entityManager->flush();

                $this->addFlash('success', ' Education created successfully!');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Unable to Add Education ');
            }
        }

        return $this->render('portfolio/education/index.html.twig', [
            'form'        => $form->createView(),
            'Educations'  => $this->educationRepository->findEducationsByUserDesc($this->getUser()),
        ]);
    }


    /**
     * ? in this Function we can edit the education
     * ? @Route("/education/edit/{id}", name="app_education_edit")
     * @param Request $request
     * @return Response
     */
    #[Route('/education/edit/{id}', name: 'app_education_edit')]
    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    public function edit(Request $request, Education $Education): Response
    {
        if ($Education->getUser() !== $this->getUser()) {
            $this->addFlash('error', 'You are not authorized to edit this Education');

            return $this->redirectToRoute('app_education');
        }

        $skills = $this->skillRepository->findSkillsByUser($this->getUser()->getId());

        $form = $this->createForm(EducationType::class, $Education, [
            'skills' => $skills,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($Education);
                $this->entityManager->flush();

                $this->addFlash('success', 'Education updated successfully!');

                return $this->redirectToRoute('app_education');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Unable to Update Education ');

                return $this->redirectToRoute('app_education');
            }
        }

        return $this->render('portfolio/education/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * ? in this Function we can delete the education
     * ? @Route("/education/delete/{id}", name="app_education_delete")
     * @param Request $request
     * @return Response
     */
    #[Route('/education/delete/{id}', name: 'app_education_delete')]
    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    public function delete(Request $request, Education $Education = null): Response
    {
        if (!$Education) {
            $this->addFlash('error', 'Education not found');

            return $this->redirectToRoute('app_education');
        }

        $this->entityManager->remove($Education);
        $this->entityManager->flush();

        $this->addFlash('success', 'Education deleted successfully!');

        return $this->redirectToRoute('app_education');
    }
}

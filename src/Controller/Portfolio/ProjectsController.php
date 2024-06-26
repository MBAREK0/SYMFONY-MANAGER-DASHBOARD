<?php

namespace App\Controller\Portfolio;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Project;
use App\Form\ProjectsType;
use App\Repository\SkillRepository;
use App\Repository\ProjectRepository;

class ProjectsController extends AbstractController
{
    private $entityManager;
    private $skillRepository;
    private $projectRepository;


    public function __construct(EntityManagerInterface $em, SkillRepository $skillRepository, ProjectRepository $projectRepository)
    {
        $this->entityManager = $em;
        $this->skillRepository = $skillRepository;
        $this->projectRepository = $projectRepository;
    }


    /**
     * ? in this Function we can add, see all the projects
     * ? @Route("/projects", name="app_projects")
     * @param Request $request
     * @return Response
     */

    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    #[Route('/projects', name: 'app_projects')]
    public function index(Request $request): Response
    {
        $Project = new Project();

        $currentUser = $this->getUser();

        // Assuming you have a method to fetch skills for the current user
        $skills = $this->skillRepository->findSkillsByUser($currentUser->getId());


        $form = $this->createForm(ProjectsType::class, $Project, [
            'skills' => $skills,
        ]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $Project->setUser($this->getUser());

            $this->entityManager->persist($Project);
            $this->entityManager->flush();

            $this->addFlash('success', 'Project created successfully!');

            return $this->redirectToRoute('app_projects');
        }


        return $this->render('portfolio/projects/index.html.twig', [
            'form'      => $form->createView(),
            'projects'  => $this->projectRepository->findProjectsByUserDesc($this->getUser()),
        ]);
    }

    /**
     * ? in this Function we can edit the projects
     * ? @Route("/projects/{id}/edit", name="app_projects_edit")
     * @param Request $request
     * @param Project $Project
     * @return Response
     */

    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    #[Route('/projects/{id}/edit', name: 'app_projects_edit')]
    public function edit(Request $request, Project $Project): Response
    {
        $currentUser = $this->getUser();

        // Assuming you have a method to fetch skills for the current user
        $skills = $this->skillRepository->findSkillsByUser($currentUser->getId());

        $form = $this->createForm(ProjectsType::class, $Project, [
            'skills' => $skills,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', 'Project updated successfully!');

            return $this->redirectToRoute('app_projects');
        }

        return $this->render('portfolio/projects/edit.html.twig', [
            'form'    => $form->createView(),
            'project' => $Project,

        ]);
    }

    /**
     * ? in this Function we can delete the projects
     * ? @Route("/projects/{id}/delete", name="app_projects_delete")
     * @param Project $Project
     * @return Response
     */

    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    #[Route('/projects/{id}/delete', name: 'app_projects_delete')]

    public function delete(Project $Project = null): Response
    {

        if ($Project === null) {
            $this->addFlash('error', 'Project not found');
            return $this->redirectToRoute('app_projects');
        }

        $this->entityManager->remove($Project);
        $this->entityManager->flush();

        $this->addFlash('success', 'Project deleted successfully!');

        return $this->redirectToRoute('app_projects');
    }
}

<?php

namespace App\Controller\Portfolio;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Skill;
use App\Form\SkillType;

class SkillsController extends AbstractController
{
    private $entityManager;


    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }


    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    #[Route('/skills', name: 'app_skills')]
    public function index(Request $request): Response
    {
        return $this->render('portfolio/skills/index.html.twig', [

        ]);
    }

    /**
     * ? @Route("/skills/create", name="app_skills_create")
     * @param Request $request
     * @return Response
     */

    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    #[Route('/skills/create', name: 'app_skills_create')]
    public function create(Request $request): Response
    {
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($skill);
            $this->entityManager->flush();

            $this->addFlash('success', 'Skill created successfully!');

            return $this->redirectToRoute('app_skills');
        }

        return $this->render('portfolio/skills/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

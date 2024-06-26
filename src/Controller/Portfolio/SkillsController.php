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
use Doctrine\DBAL\Connection;

class SkillsController extends AbstractController
{
    private $entityManager;


    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    /**
     * ? in this Function we can add and see all the skills
     * ? @Route("/skills", name="app_skills")
     * @param Request $request
     * @return Response
     */

    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    #[Route('/skills', name: 'app_skills')]
    public function index(Request $request): Response
    {
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $skill->setUser($this->getUser());

                $this->entityManager->persist($skill);
                $this->entityManager->flush();

                $this->addFlash('success', 'Skill created successfully!');

                return $this->redirectToRoute('app_skills');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Skill name is already in use.');
            }
        }

        return $this->render('portfolio/skills/index.html.twig', [
            'form'   => $form->createView(),
            'skills' => $this->getUser()->getSkills(),
        ]);
    }

    /**
     * ? @Route("/skills/{id}/edit", name="app_skills_edit")
     * @param Request $request
     * @param Skill $skill
     * @return Response
     */

    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    #[Route('/skills/{id}/edit', name: 'app_skills_edit')]
    public function edit(Request $request, Skill $skill): Response
    {
        $form = $this->createForm(SkillType::class, $skill);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', 'Skill updated successfully!');

            return $this->redirectToRoute('app_skills');
        }

        return $this->render('portfolio/skills/edit.html.twig', [
            'form'  => $form->createView(),
            'skill' => $skill,
        ]);
    }

    /**
     * ? @Route("/skills/{id}/delete", name="app_skills_delete")
     * @param Skill $skill
     * @return Response
     */

    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    #[Route('/skills/{id}/delete', name: 'app_skills_delete')]
    public function delete(Skill $skill,Connection $connection): Response
    {
        try {

            $sql = "DELETE FROM Skill WHERE id = :skillId";
          
            $stmt = $connection->prepare($sql);
            $stmt->bindValue('skillId', $skill->getId() )   ;
            $stmt->execute();

            $this->addFlash('success', 'Skill deleted successfully!');
           
        } catch (\Exception $e) {
            
            $this->addFlash('error', 'Error deleting skill please try again later');

        }
        return $this->redirectToRoute('app_skills');
       
    }
}

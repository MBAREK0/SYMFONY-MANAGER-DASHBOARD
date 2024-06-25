<?php

namespace App\Controller\Portfolio;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Award;
use App\Form\AwardType;
use App\Repository\AwardRepository;
use App\Repository\SkillRepository;

class AwardController extends AbstractController
{
    private $entityManager;
    private $awardRepository;
    private $skillRepository;


    public function __construct(EntityManagerInterface $em, AwardRepository $awardRepository , SkillRepository $skillRepository)
    {
        $this->entityManager = $em;
        $this->skillRepository = $skillRepository;
        $this->awardRepository = $awardRepository;
    }


    /**
     * ? in this Function we can add, see all the award
     * ? @Route("/award", name="app_award")
     * @param Request $request
     * @return Response
     */

    #[Route('/award', name: 'app_award')]
    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    public function index(Request $request): Response
    {
        $Award = new Award();

        $currentUser = $this->getUser();

        // Assuming you have a method to fetch skills for the current user
        $skills = $this->skillRepository->findSkillsByUser($currentUser->getId());


        $form = $this->createForm(AwardType::class, $Award, [
            'skills' => $skills,
        ]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
                try {
                    $Award->setUser($this->getUser());

                    $this->entityManager->persist($Award);
                    $this->entityManager->flush();
        
                    $this->addFlash('success', ' Award created successfully!');
        
                    return $this->redirectToRoute('app_education');
                }
                catch (\Exception $e) {
                   throw new \Exception('Error creating Award');
                }
        }

        return $this->render('portfolio/award/index.html.twig', [
            'form'      => $form->createView(),
            'Awards'  => $this->awardRepository->findAwardsByUserDesc($this->getUser()),
        ]);
    }


    /**
     * ? in this Function we can edit the award
     * ? @Route("/award/edit/{id}", name="app_award_edit")
     * @param Request $request
     * @return Response
     */

    #[Route('/award/edit/{id}', name: 'app_award_edit')]
    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    public function edit(Request $request, Award $award): Response
    {
        $currentUser = $this->getUser();

        // Assuming you have a method to fetch skills for the current user
        $skills = $this->skillRepository->findSkillsByUser($currentUser->getId());

        $form = $this->createForm(AwardType::class, $award, [
            'skills' => $skills,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($award);
                $this->entityManager->flush();

                $this->addFlash('success', 'Award updated successfully!');

                return $this->redirectToRoute('app_award');
            }
            catch (\Exception $e) {
                throw new \Exception('Error updating award');
            }
        }

        return $this->render('portfolio/award/edit.html.twig', [
            'form' => $form->createView(),
            'award' => $award,
        ]);
    }

    

    /**
     * ? in this Function we can delete the award
     * ? @Route("/award/delete/{id}", name="app_award_delete")
     * @param Award $award
     * @return Response
     */
    #[Route('/award/delete/{id}', name: 'app_award_delete')]
    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    public function delete(Award $award): Response
    {
        $this->entityManager->remove($award);
        $this->entityManager->flush();

        $this->addFlash('success', 'Award deleted successfully!');

        return $this->redirectToRoute('app_award');
    }
}

<?php

namespace App\Controller\Portfolio;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Language;
use App\Form\LanguageType;
use App\Repository\LanguageRepository;

class LanguageController extends AbstractController
{
    private $entityManager;
    private $LanguageRepository;



    public function __construct(EntityManagerInterface $em, LanguageRepository $LanguageRepository)
    {
        $this->entityManager = $em;
        $this->LanguageRepository = $LanguageRepository;
    }


    /**
     * ? in this Function we can add, see all the Language
     * ? @Route("/Language", name="app_Language")
     * @param Request $request
     * @return Response
     */

    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    #[Route('/language', name: 'app_language')]
    public function index(Request $request): Response
    {
        $Language = new Language();
        $form = $this->createForm(LanguageType::class, $Language);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($Language->getNameEn() == null && $Language->getProficiencyEn() == null) {
                $this->addFlash('error', 'Please enter a name Or a level.');

                return $this->redirectToRoute('app_language');
            }

            try {
                $Language->setUser($this->getUser());

                $this->entityManager->persist($Language);
                $this->entityManager->flush();

                $this->addFlash('success', 'Language created successfully!');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Error creating Language');
            }
        }

        foreach ($form->getErrors(true) as $error) {
            $this->addFlash('error', $error->getMessage());
        }

        return $this->render('portfolio/language/index.html.twig', [
            'form'       => $form->createView(),
            'languages'  => $this->getUser()->getLanguages(),
        ]);
    }


    /**
     * ? in this Function we can edit the Language
     * ? @Route("/Language/{id}/edit", name="app_language_edit")
     * @param Request $request
     * @param Language $Language
     */

    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    #[Route('/language/{id}/edit', name: 'app_language_edit')]
    public function edit(Request $request, Language $Language): Response
    {
        $form = $this->createForm(LanguageType::class, $Language);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($Language->getNameEn() == null && $Language->getProficiencyEn() == null) {
                $this->addFlash('error', 'Please enter a name Or a level.');

                return $this->redirectToRoute('app_language');
            }

            try {
                $Language->setUser($this->getUser());

                $this->entityManager->persist($Language);
                $this->entityManager->flush();

                $this->addFlash('success', 'Language updated successfully!');

                return $this->redirectToRoute('app_language');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Error updating Language');

                return $this->redirectToRoute('app_language');
            }
        }

        foreach ($form->getErrors(true) as $error) {
            $this->addFlash('error', $error->getMessage());
        }

        return $this->render('portfolio/language/edit.html.twig', [
            'form'      => $form->createView(),
            'language'  => $Language,
        ]);
    }

    /**
     * ? in this Function we can delete the Language
     * ? @Route("/Language/{id}/delete", name="app_language_delete")
     * @param Language $Language
     */

    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    #[Route('/language/{id}/delete', name: 'app_language_delete')]
    public function delete(Language $Language): Response
    {
        if (!$Language) {
            $this->addFlash('error', 'Language not found');

            return $this->redirectToRoute('app_language');
        }

        try {
            $this->entityManager->remove($Language);
            $this->entityManager->flush();

            $this->addFlash('success', 'Language deleted successfully!');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Error deleting Language');
        }

        return $this->redirectToRoute('app_language');
    }
}

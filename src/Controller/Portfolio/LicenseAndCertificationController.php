<?php

namespace App\Controller\Portfolio;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\LicenseAndCertification;
use App\Form\LicenseOrCertificationType;
use App\Repository\LicenseAndCertificationRepository;
use App\Repository\SkillRepository;

class LicenseAndCertificationController extends AbstractController
{
    private $entityManager;
    private $LicenseAndCertificationRepository;
    private $skillRepository;

    public function __construct(
        EntityManagerInterface $em,
        LicenseAndCertificationRepository $LicenseAndCertificationRepository,
        SkillRepository $skillRepository
    ) {
        $this->entityManager = $em;
        $this->skillRepository = $skillRepository;
        $this->LicenseAndCertificationRepository = $LicenseAndCertificationRepository;
    }


    /**
     * ? in this Function we can add, see all the License and Certification
     * ? @Route("/license_or_certification", name="app_license_or_certification")
     * @param Request $request
     * @return Response
     */

    #[Route('/license_or_certification', name: 'app_license_or_certification')]
    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    public function index(Request $request): Response
    {
        $LicenseAndCertification = new LicenseAndCertification();

        $skills = $this->skillRepository->findSkillsByUser($this->getUser()->getId());

        $form = $this->createForm(LicenseOrCertificationType::class, $LicenseAndCertification, [
            'skills' => $skills,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $LicenseAndCertification->setUser($this->getUser());

                $this->entityManager->persist($LicenseAndCertification);
                $this->entityManager->flush();

                $this->addFlash('success', 'License or Certification created successfully!');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Unable to Add License Or Certification');
            }
        }

        foreach ($form->getErrors(true) as $error) {
            $this->addFlash('error', $error->getMessage());
        }

        return $this->render('portfolio/license_and_certification/index.html.twig', [
            'form'                    => $form->createView(),
            'LicenseAndCertification' => $this->LicenseAndCertificationRepository->findLicenseAndCertificationByUserDesc($this->getUser()),

        ]);
    }


    /**
     * ? in this Function we can edit the License and Certification
     * ? @Route("/license_or_certification/{id}/edit", name="app_license_or_certification_edit")
     * @param Request $request
     * @param LicenseAndCertification $LicenseAndCertification
     * @return Response
     */

    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    #[Route('/license_or_certification/{id}/edit', name: 'app_license_or_certification_edit')]
    public function edit(Request $request, LicenseAndCertification $LicenseAndCertification): Response
    {
        if ($LicenseAndCertification->getUser() !== $this->getUser()) {
            $this->addFlash('error', 'You are not authorized to edit this License Or Certification');

            return $this->redirectToRoute('app_license_or_certification');
        }

        $skills = $this->skillRepository->findSkillsByUser($this->getUser()->getId());

        $form = $this->createForm(LicenseOrCertificationType::class, $LicenseAndCertification, [
            'skills' => $skills,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $LicenseAndCertification->setUser($this->getUser());

                $this->entityManager->persist($LicenseAndCertification);
                $this->entityManager->flush();

                $this->addFlash('success', 'License or Certification updated successfully!');

                return $this->redirectToRoute('app_license_or_certification');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Unable to Update License Or Certification');

                return $this->redirectToRoute('app_license_or_certification');
            }
        }

        foreach ($form->getErrors(true) as $error) {
            $this->addFlash('error', $error->getMessage());
        }

        return $this->render('portfolio/license_and_certification/edit.html.twig', [
            'form'                    => $form->createView(),
            'LicenseAndCertification' => $LicenseAndCertification,

        ]);
    }


    /**
     * ? in this Function we can delete the License and Certification
     * ? @Route("/license_or_certification/{id}/delete", name="app_license_or_certification_delete")
     * @param LicenseAndCertification $LicenseAndCertification
     * @return Response
     */

    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    #[Route('/license_or_certification/{id}/delete', name: 'app_license_or_certification_delete')]
    public function delete(LicenseAndCertification $LicenseAndCertification = null): Response
    {
        if (!$LicenseAndCertification) {
            $this->addFlash('error', 'License or Certification not found');

            return $this->redirectToRoute('app_license_or_certification');
        }

        $this->entityManager->remove($LicenseAndCertification);
        $this->entityManager->flush();

        $this->addFlash('success', 'License or Certification deleted successfully!');

        return $this->redirectToRoute('app_license_or_certification');
    }
}

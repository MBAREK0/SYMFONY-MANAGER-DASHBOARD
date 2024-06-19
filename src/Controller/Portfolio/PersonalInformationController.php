<?php

namespace App\Controller\Portfolio;

use App\Service\PersonalInformationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PersonalInformationController extends AbstractController
{
    private $personalInformationService;
    private $csrfTokenManager;
    private $userRepository;
    private $entityManager;
    private UserPasswordHasherInterface $hasher;

    public function __construct(
        PersonalInformationService $personalInformationService,
        CsrfTokenManagerInterface $csrfTokenManager,
        UserRepository $userRepository,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher
    ) {
        $this->personalInformationService = $personalInformationService;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->userRepository = $userRepository;
        $this->entityManager = $em;
        $this->hasher = $hasher;
    }

    /**
     * ? @Route("/personal_information", name="app_personal_information")
     * @param RequestStack $requestStack
     * @return Response
     * @throws \Exception
     */

    #[Route('/personal_information', name: 'app_personal_information')]
    public function index(RequestStack $requestStack): Response
    {
        $csrfToken = bin2hex(openssl_random_pseudo_bytes(16));

        $session = $requestStack->getSession();
        $session->set('csrf_token', $csrfToken);
        $PersonalInformation = $this->personalInformationService->getInfo();

        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_auth');
        }

        return $this->render('portfolio/personal_information/index.html.twig', [
            'PersonalInformation'  => $PersonalInformation ,
            'csrf_token'            => $csrfToken,
            'user'                  => $user,
        ]);
    }

    /**
     * ? @Route("/personal_information/update", name="app_update_personal_information")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */

    #[Route('/personal_information/update', name: 'app_update_personal_information')]
    public function update(Request $request): Response
    {
        if ($request->request->get('id')) {
            try {
                $personalInformation = $this->personalInformationService->updateInfo($request->request->get('id'), $request);
                if ($personalInformation->getId()) {
                    $this->addFlash('success', 'Personal Information Updated successfully');
                } else {
                    $this->addFlash('error', 'Personal Information not Updated Please try again later');
                }

                return $this->redirectToRoute('app_personal_information');
            } catch (\Exception $e) {
                return new Response('An error occurred: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            try {
                $personalInformation = $this->personalInformationService->createInfo($request);
                if ($personalInformation->getId()) {
                    $this->addFlash('success', 'Personal Information Created successfully');
                } else {
                    $this->addFlash('error', 'Personal Information not Created Please try again later');
                }

                return $this->redirectToRoute('app_personal_information');
            } catch (\Exception $e) {
                return new Response('An error occurred: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}

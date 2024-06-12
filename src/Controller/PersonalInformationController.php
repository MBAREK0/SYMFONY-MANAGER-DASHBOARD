<?php

namespace App\Controller;

use App\Service\PersonalInformationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\UserRepository;
use App\Entity\User;
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
     * @Route("/personal_information", name="app_personal_information")
     */

    #[Route('/personal_information', name: 'app_personal_information')]
    public function index(RequestStack $requestStack): Response
    {
        $csrfToken = bin2hex(openssl_random_pseudo_bytes(16));

        $session = $requestStack->getSession();
        $session->set('csrf_token', $csrfToken);
        $PersonalInformations = $this->personalInformationService->getInfo();

        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_auth');
        }

        return $this->render('portfolio/personal_information/index.html.twig', [
            'PersonalInformations'  => $PersonalInformations,
            'csrf_token'            => $csrfToken,
            'user'                  => $user,
        ]);
    }

    /**
     * @Route("/personal_information/update", name="app_update_personal_information")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */

    #[Route('/personal_information/update', name: 'app_update_personal_information')]
    public function update(Request $request): Response
    {
        if ($request->request->get('id')) {
            try {
                $this->personalInformationService->updateInfo($request->request->get('id'), $request);

                return $this->redirectToRoute('app_personal_information');
            } catch (\Exception $e) {
                return new Response('An error occurred: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            try {
                $this->personalInformationService->createInfo($request);

                return $this->redirectToRoute('app_personal_information');
            } catch (\Exception $e) {
                return new Response('An error occurred: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    /**
     * @Route("/owner/credentials/update/{id}", name="app_update_owner_password")
     * @param int $id
     * @param Request $request
     * @return Response
     */

    #[Route('/owner/credentials/update/{id}', name: 'app_update_owner_password', methods: ['POST'])]
    public function updatePassword(int $id, Request $request): Response
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);


        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }


        // Update  password
        $old_password =  $request->get('_old_password');
        if (!$this->hasher->isPasswordValid($user, $old_password)) {
            $this->addFlash('error', 'Incorrect old password');
            return $this->redirectToRoute('app_personal_information');
            
            }
            
            $password = $this->hasher->hashPassword(
                $user,
                $request->request->get('_new_password')
                );
                $user->setPassword($password);
                
                $this->entityManager->flush();
                
                $this->addFlash('success', 'Password changed successfully');
                return $this->redirectToRoute('app_personal_information');
                }
                }
                
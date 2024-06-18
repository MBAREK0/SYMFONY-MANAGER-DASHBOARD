<?php

namespace App\Controller\Settings;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Service\PersonalInformationService;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SettingsController extends AbstractController
{
    private $entityManager;
    private $user;
    private UserPasswordHasherInterface $hasher;


    public function __construct(
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher
    ) {
        $this->entityManager = $em;
        $this->hasher = $hasher;
    }

    /**
     * ? @Route("/settings", name="app_settings")
     * @param RequestStack $requestStack
     * @return Response
     * @throws \Exception
     */

    #[Route('/settings', name: 'app_settings')]
    public function index(RequestStack $requestStack): Response
    {
        $csrfToken = bin2hex(openssl_random_pseudo_bytes(16));

        $session = $requestStack->getSession();
        $session->set('csrf_token', $csrfToken);
        // $PersonalInformations = $this->personalInformationService->getInfo();

        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_auth_sign_in');
        }

        return $this->render('settings/index.html.twig', [
            'user'       => $user,
            'csrf_token' => $csrfToken,

        ]);
    }


    /**
     * ? @Route("/settings/credentials/update/{id}", name="app_update_credentials", methods={"POST"})
     * @param User $user*
     * @param Request $request
     * @return Response
     * @throws \Exception
     */

    #[Route('/settings/credentials/update/{id}', name: 'app_update_credentials', methods: ['POST'])]
    public function updatePassword(User $user, Request $request): Response
    {
        $session = $request->getSession();
        $sesstion_csrf_token = $session->get('csrf_token');

        if ($sesstion_csrf_token != $request->get('csrf_token')) {
            throw new \Exception('Invalid CSRF token');
        }

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        // Update  password
        $old_password = $request->get('_old_password');
        if (!$this->hasher->isPasswordValid($user, $old_password)) {
            $this->addFlash('error', 'Incorrect old password');

            return $this->redirectToRoute('app_settings');
        }

        $password = $this->hasher->hashPassword(
            $user,
            $request->request->get('_new_password')
        );
        $user->setPassword($password);

        $this->entityManager->flush();

        $this->addFlash('success', 'Password changed successfully');

        return $this->redirectToRoute('app_settings');
    }
}

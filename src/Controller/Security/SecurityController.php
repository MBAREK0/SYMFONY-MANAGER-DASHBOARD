<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\UserRepository;

class SecurityController extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * ? @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */


    #[Route('/auth/sign_in', name: 'app_auth_sign_in') , methods(['GET']) ]
    public function index(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('auth/sign_in.html.twig', [
            'error'         => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    /**
     * ? @Route("/sign_up", name="app_sign_up")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */

    #[Route('/auth/sign_up', name: 'app_auth_sign_up') , methods(['GET']) ]
    public function owner_index(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('auth/sign_up.html.twig', [
            'error'         => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }


    /**
     * ? @Route("/logout", name="app_logout")
     * @return void
     */

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
    }
}

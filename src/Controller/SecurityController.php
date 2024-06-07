<?php

namespace App\Controller;


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
    #[Route('/auth', name: 'app_auth') , methods (['GET']) ]
    public function index(Request $request,AuthenticationUtils $authenticationUtils): Response
    {

        $email = $this->userRepository->findOneBy([])->getEmail();
        return $this->render('auth/index.html.twig', [
            'error'         => $authenticationUtils->getLastAuthenticationError(),
            'email' => $email,
        ]);
    }
    
 

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
       
    }
   
}

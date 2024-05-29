<?php

namespace App\Controller;

use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use App\Controller\BaseController;



class AuthController extends AbstractController
{
    private $csrfTokenManager;

    public function __construct(CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->csrfTokenManager = $csrfTokenManager;
    }
    #[Route('/auth', name: 'app_auth')]
    public function index(Request $request): Response
    {
        $csrfToken = $this->csrfTokenManager->getToken('csrf')->getValue();
        $session = $request->getSession();
        $session->set('csrf_token', $csrfToken);
     
        return $this->render('auth/index.html.twig', [
            'controller_name' => 'AuthController',
            'csrf_token' => $csrfToken
        ]);
    }
    #[Route('/auth/login', name: 'app_auth_login', methods: ['POST'])]
    public function login(Request $request, AuthService $AuthService): Response
    {
        // dd($request->request->all());
        $session = $request->getSession();
     
        $csrfToken = $session->get('csrf_token');
        $submittedToken = $request->request->get('csrf_token');
        if ($csrfToken !== $submittedToken) {
            return $this->redirectToRoute('app_auth');
        }
        
        $password = $request->request->get('password');
       $check =  $AuthService->login($request);
       if($check){
        $session->set('is_i_log_in', true);
       
        return $this->redirectToRoute('app_home');
       }
       else{
        return $this->redirectToRoute('app_auth');
       }
      
    }
    #[Route('/auth/logout', name: 'app_auth_logout')]
    public function logout(Request $request): Response
    {
        $session = $request->getSession();
        $session->invalidate();
        return $this->redirectToRoute('app_auth');
    }
}

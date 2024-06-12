<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RequestStack;

class SettingsController extends AbstractController
{
    #[Route('/settings', name: 'app_settings')]
    public function index(RequestStack $requestStack): Response
    {
        $csrfToken = bin2hex(openssl_random_pseudo_bytes(16));

        $session = $requestStack->getSession();
        $session->set('csrf_token', $csrfToken);
        // $PersonalInformations = $this->personalInformationService->getInfo();

        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_auth');
        }
        return $this->render('settings/index.html.twig', [
            'user' => $user,
            'csrf_token' => $csrfToken

        ]);
    }

    
}

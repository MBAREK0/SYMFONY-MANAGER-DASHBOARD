<?php

namespace App\Controller\Portfolio;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MediaController extends AbstractController
{
    #[Route('/media', name: 'app_media')]
    public function index(): Response
    {
        return $this->render('portfolio/media/index.html.twig', [
            'controller_name' => 'MediaController',
        ]);
    }
}

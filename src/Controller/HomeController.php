<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HomeController extends BaseController
{

    #[Route('/', name: 'app_home')]
    public function index( ): Response
    {
        
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
class BaseController extends AbstractController
{

    protected $session;

    public function __construct()
    {
    $this->access();
    }



    
    protected function access(): void
    {
          
        $is_session_runed = session_status() === PHP_SESSION_ACTIVE ? true : false;
        if(!$is_session_runed){
            $session = new Session();
            $session->start();
            $this->session = $session;
        }else{
            $this->session = new Session();
        }

    

        
       

        // Example of accessing session data
     

        if (!$this->session->get('is_i_log_in')) {

                $htmlContent = '<a href="/auth" style="font-size: 14px; color: #000;">Login</a>';
                echo $htmlContent;

                dump('You are not authorized to access this page (:');
                die(); 
        }
    }

}



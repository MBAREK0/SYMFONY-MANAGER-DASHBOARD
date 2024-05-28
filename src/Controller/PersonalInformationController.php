<?php

namespace App\Controller;

use App\Service\PersonalInformationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class PersonalInformationController extends AbstractController
{
    private $personalInformationService;
    private $csrfTokenManager;
    

    public function __construct(PersonalInformationService $personalInformationService,CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->personalInformationService = $personalInformationService;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    /**
     * @Route("/personal_information", name="app_personal_information")
     * 
     */

    #[Route('/personal_information', name: 'app_personal_information')]
    public function index(Request $request): Response
    {
        $csrfToken = $this->csrfTokenManager->getToken('csrf')->getValue();
        $session = $request->getSession();
        $session->set('csrf_token', $csrfToken);
        $data  = $this->personalInformationService->getInfo();
      
        return $this->render('personal_information/index.html.twig', [
            'controller_name' => 'PersonalInformationController',
            'data' => $data,
            'csrf_token' => $csrfToken,
        ]);
    }

    
    /**
     * @Route("/personal_information/{id}/update", name="app_update_personal_information")
     * 
     */

    #[Route('/personal_information/update', name: 'app_update_personal_information')]
    public function update(Request $request): Response
    {
        
        
        if ( $request->request->get('id')) {
       
         
         try {
             $this->personalInformationService->updateInfo($request->request->get('id'),$request);
             return $this->redirectToRoute('app_personal_information');
            } catch (\Exception $e) {
                return new Response('An error occurred: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            
        }else{
            
           
        try {
            $this->personalInformationService->createInfo($request);
            return $this->redirectToRoute('app_personal_information');
            } catch (\Exception $e) {
                return new Response('An error occurred: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }

        }
    }
    
}
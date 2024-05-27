<?php

namespace App\Controller;

use App\Service\PersonalInformationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PersonalInformationController extends AbstractController
{
    private $personalInformationService;

    public function __construct(PersonalInformationService $personalInformationService)
    {
        $this->personalInformationService = $personalInformationService;
    }

    /**
     * @Route("/personal_information", name="app_personal_information")
     */

    #[Route('/personal_information', name: 'app_personal_information')]
    public function index(): Response
    {
        $data  = $this->personalInformationService->getInfo();
        // dd($data);
        return $this->render('personal_information/index.html.twig', [
            'controller_name' => 'PersonalInformationController',
            'data' => $data
        ]);
    }
    
    /**
     * @Route("/personal_information/{id}/update", name="app_update_personal_information")
     */

    #[Route('/personal_information/{id}/update', name: 'app_update_personal_information')]
    public function update(int $id ,Request $request): Response
    {
       
     if ($id) {
        
        try {
            $this->personalInformationService->updateInfo($id,$request);
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
<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

class SecurityController extends AbstractController
{
    private $userRepository;
    private UserPasswordHasherInterface $hasher;
    private $entityManager;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $em,
    ) {
        $this->entityManager = $em;
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
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

    #[Route('/auth/create_new_user', name: 'app_auth_create_user') , methods(['GET']) ]
    public function create_new_user(Request $request): Response
    {
        $User = new User();
        $form = $this->createForm(UserType::class, $User);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $User->setEmail($form->get('email')->getData());
            $User->setRoles($form->get('roles')->getData());
            $password = $this->hasher->hashPassword(
                $User,
                $form->get('password')->getData()
            );
            $User->setPassword($password);


            $this->entityManager->persist($User);
            $this->entityManager->flush();

            $this->addFlash('success', 'User Created successfully');

            return $this->redirectToRoute('app_auth_create_user');
        }

        return $this->render('auth/add_users.html.twig', [
            'form' => $form->createView(),


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

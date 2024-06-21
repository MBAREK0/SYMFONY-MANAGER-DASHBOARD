<?php

namespace App\Controller\Portfolio;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Media;
use App\Form\MediaType;

class MediaController extends AbstractController
{

    private $entityManager;


    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    
/**
 * ? in this Function we can add, see all the media
 * ? @Route("/media", name="app_media")
 * @param Request $request
 * @return Response
 */

    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    #[Route('/media', name: 'app_media')]
    public function index(Request $request): Response
    {
        $Medium = new Media();
        $form = $this->createForm(MediaType::class, $Medium);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $Medium->setUser($this->getUser());

            $this->entityManager->persist($Medium);
            $this->entityManager->flush();

            $this->addFlash('success', 'media created successfully!');

            return $this->redirectToRoute('app_media');
        }

        return $this->render('portfolio/media/index.html.twig', [
            'form'   => $form->createView(),
            'media' => $this->getUser()->getMedia(),
        ]);
    }

    /**
     * ? in this Function we can edit the media
     * ? @Route("/media/{id}/edit", name="app_media_edit")
     * @param Request $request
     * @param Media $medium
     * @return Response
     */

    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    #[Route('/media/{id}/edit', name: 'app_media_edit')]
    public function edit(Request $request, Media $medium): Response
    {
        $form = $this->createForm(MediaType::class, $medium);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', 'Medium updated successfully!');

            return $this->redirectToRoute('app_media');
        }

        return $this->render('portfolio/media/edit.html.twig', [
            'form'  => $form->createView(),
            'medium' => $medium,
        ]);
    }

    /**
     * ? in this Function we can delete the media
     * ? @Route("/media/{id}/delete", name="app_media_delete")
     * @param Media $medium
     * @return Response
     */

    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    #[Route('/media/{id}/delete', name: 'app_media_delete')]
    public function delete(Media $medium): Response
    {
        $this->entityManager->remove($medium);
        $this->entityManager->flush();

        $this->addFlash('success', 'Medium deleted successfully!');

        return $this->redirectToRoute('app_media');
    }

}

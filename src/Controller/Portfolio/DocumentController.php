<?php

namespace App\Controller\Portfolio;

use App\Entity\Document;
use App\Form\DocumentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class DocumentController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * ? in the function we are creating a new document and saving it to the database
     * @Route("/document", name="document")
     * @param Request $request
     * @param SluggerInterface $slugger
     * @return Response
     */

    #[Route('/document', name: 'app_document')]
    public function index(Request $request, SluggerInterface $slugger): Response
    {
        $document = new Document();
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();

            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('document_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Document could not be uploaded!');
                }

                $document->setFileName($newFilename);
                $document->setUser($this->getUser());
            }

            $this->em->persist($document);
            $this->em->flush();
            $this->addFlash('success', 'Document added successfully!');
        }

        foreach ($form->getErrors(true) as $error) {
            $this->addFlash('error', $error->getMessage());
        }


        return $this->render('portfolio/document/index.html.twig', [
            'documents' => $documents = $this->getUser()->getDocuments(),
            'form'      => $form->createView(),
        ]);
    }

    /**
     * ? in the function we are downloading a document
     * @Route("/document/download/{id}", name="document_download")
     * @param Document $document
     * @return Response
     */

     #[Route('/api/document/download/{name}', name: 'app_document_download')]
     public function download(string $name): Response
     {
  
         $document = $this->em->getRepository(Document::class)->findOneBy(['fileName' => $name]);
     
         if (!$document) {

             throw $this->createNotFoundException('The document does not exist.');
         }
     

         $filePath = $this->getParameter('document_directory') . '/' . $document->getFileName();
     
         if (!file_exists($filePath)) {

             throw $this->createNotFoundException('The document file does not exist.');
         }
     
         return $this->file($filePath);
     }

    /**
     * ? in the function we are deleting a document
     * @Route("/document/delete/{id}", name="document_delete")
     * @param Document $document
     * @param EntityManagerInterface $em
     * @return Response
     */

    #[Route('/document/delete/{id}', name: 'app_document_delete')]
    public function delete(Document $document): Response
    {
        try {
            $this->em->remove($document);
            $this->em->flush();
            $this->addFlash('success', 'Document deleted successfully!');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Document could not be deleted!');
        }

        return $this->redirectToRoute('app_document');
    }


    /**
     * ? in the function we are editing a document
     * @Route("/document/edit/{id}", name="document_edit")
     * @param Document $document
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */

    #[Route('/document/edit/{id}', name: 'app_document_edit')]
    public function edit(Document $document, Request $request, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(DocumentType::class, $document);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('document_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Document could not be uploaded!');
                }

                $document->setFileName($newFilename);
            }

            $this->em->persist($document);
            $this->em->flush();

            $this->addFlash('success', 'Document updated successfully!');

            return $this->redirectToRoute('app_document');
        }

        return $this->render('portfolio/document/edit.html.twig', [
            'form'     => $form->createView(),
            'document' => $document,
        ]);
    }
}

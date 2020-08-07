<?php

namespace App\Controller;

use App\DTO\Request\AddBookRequest;
use App\Exception\BaseException;
use App\Form\BookType;
use App\Services\Application\AddBook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UploadBookController extends AbstractController
{
    /**
     * @Route("/upload", name="upload_book", methods={"GET", "POST"})
     * @param Request $request
     * @param AddBook $addBookService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, AddBook $addBookService)
    {
        $form = $this->createForm(BookType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $fileName = $form->get('file')->getData();
                $addBookRequest = new AddBookRequest(file_get_contents($fileName));
                $addBookService->execute($addBookRequest);
                $this->addFlash('success', 'Uploaded.');
            } catch (BaseException $e) {
                $this->addFlash('error', $e->getMessage());
            }
            return $this->redirect($this->generateUrl('upload_book'));
        }

        return $this->render('upload/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

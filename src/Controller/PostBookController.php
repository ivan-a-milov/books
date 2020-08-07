<?php

namespace App\Controller;

use App\DTO\Request\AddBookRequest;
use App\Exception\BaseException;
use App\Services\Application\AddBook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostBookController extends AbstractController
{
    /**
     * @Route("/post", name="post_book", methods={"POST"})
     * @param Request $request
     * @param AddBook $addBookService
     * @return Response
     */
    public function index(Request $request, AddBook $addBookService)
    {
        $response = new Response('', Response::HTTP_OK);
        try {
            $addBookRequest = new AddBookRequest($request->getContent());
            $addBookService->execute($addBookRequest);
        } catch (BaseException $e) {
            $response = new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return $response;
    }
}

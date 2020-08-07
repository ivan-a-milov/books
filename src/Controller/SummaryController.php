<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SummaryController extends AbstractController
{
    /**
     * @Route("/summary", name="summary", methods={"GET"})
     */
    public function index()
    {
        return new JsonResponse(['foo' => 'bar']);
    }
}

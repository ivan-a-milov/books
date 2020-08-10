<?php

namespace App\Controller;

use App\Services\Application\Summary;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SummaryController extends AbstractController
{
    /**
     * @Route("/summary", name="summary", methods={"GET"})
     * @param Summary $summary
     * @return JsonResponse
     */
    public function index(Summary $summary)
    {
        return new JsonResponse($summary->count());
    }
}

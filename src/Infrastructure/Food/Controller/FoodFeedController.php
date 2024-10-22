<?php

namespace App\Infrastructure\Food\Controller;

use App\Application\Food\ProcessFoodRequest;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FoodFeedController extends AbstractController
{
    public function __construct(private readonly ProcessFoodRequest $processFoodRequest)
    {
    }

    #[Route('/food', methods: ['POST'])]
    public function process(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            throw new Exception('Invalid JSON provided');
        }

        ($this->processFoodRequest)($data);

        return new Response('Food items added successfully', Response::HTTP_CREATED);
    }
}

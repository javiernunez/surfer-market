<?php

namespace App\Infrastructure\Food\Controller;


use App\Application\Food\SearchFood;
use App\Application\Food\SearchFoodValidator;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FoodSearchController extends AbstractController
{
    public function __construct(
        private readonly SearchFoodValidator $validator,
        private readonly SearchFood $searchFood
    ) {}

    #[Route('/food/search', methods: ['GET'])]
    public function search(Request $request): Response
    {
        try {
            $filters = $request->query->all();
            $this->validator->validate($filters);
            $results = ($this->searchFood)($filters);

            return new Response($results->toJson());
        } catch (Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}

<?php

namespace App\Infrastructure\Food\Controller;

use App\Domain\Food\FoodRepositoryInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FoodAllController extends AbstractController
{
    public function __construct(private readonly FoodRepositoryInterface $foodRepository)
    {
    }

    #[Route('/food', methods: ['GET'])]
    public function process(): Response
    {
        try {
            $foodItems = $this->foodRepository->getAll();

            return new Response($foodItems->toJson());
        } catch (Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}

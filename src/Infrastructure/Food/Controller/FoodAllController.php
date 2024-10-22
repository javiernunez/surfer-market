<?php

namespace App\Infrastructure\Food\Controller;

use App\Domain\Food\FoodRepositoryInterface;
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
        $foodItems = $this->foodRepository->getAll();

        return new Response(json_encode($foodItems), Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}

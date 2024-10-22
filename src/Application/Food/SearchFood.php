<?php

namespace App\Application\Food;

use App\Domain\Food\FoodCollection;
use App\Domain\Food\FoodRepositoryInterface;

class SearchFood
{
    public function __construct(private readonly FoodRepositoryInterface $foodRepository)
    {
    }

    public function __invoke(array $filters): FoodCollection
    {
        return $this->foodRepository->search($filters);
    }
}

<?php

namespace App\Application\Food;

use App\Domain\Food\FoodRepositoryInterface;
use App\Domain\Food\Fruit\Fruit;
use App\Domain\Food\Vegetable\Vegetable;
use App\Domain\Global\Enum\Unit;

readonly class ProcessFoodRequest
{
    public function __construct(
        private FoodRepositoryInterface $foodRepository,
        private ProcessFoodRequestValidator $validator
    ) {}

    public function __invoke(array $foodItems): void
    {
        foreach ($foodItems as $item) {
            $this->validator->validate($item);

            if ($item['type'] === 'fruit') {
                $fruit = Fruit::create(
                    (int)$item['id'],
                    $item['name'],
                    (int)$item['quantity'],
                    Unit::fromString($item['unit'])
                );
                $this->foodRepository->save($fruit);
            } elseif ($item['type'] === 'vegetable') {
                $vegetable = Vegetable::create(
                    (int)$item['id'],
                    $item['name'],
                    (int)$item['quantity'],
                    Unit::fromString($item['unit'])
                );
                $this->foodRepository->save($vegetable);
            }
        }
    }
}

<?php

namespace App\Domain\Food;

use App\Domain\Food\Fruit\Fruit;

class FoodCollection
{
    private array $foods = [];

    public function __construct(array $foods = [])
    {
        foreach ($foods as $food) {
            $this->add($food);
        }
    }

    public function add(Food $food): void
    {
        $this->foods[] = $food;
    }

    public function all(): array
    {
        return $this->foods;
    }

    public function count(): int
    {
        return count($this->foods);
    }

    public function toJson(): string
    {
        return json_encode($this->foods, JSON_PRETTY_PRINT);
    }
}

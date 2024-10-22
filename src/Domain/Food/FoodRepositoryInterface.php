<?php

namespace App\Domain\Food;

interface FoodRepositoryInterface
{
    public function save(Food $food): void;

    public function getAll(): FoodCollection;

    public function search(array $filters): FoodCollection;
}

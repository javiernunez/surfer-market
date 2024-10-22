<?php

namespace App\Domain\Food;

interface FoodRepositoryInterface
{
    public function save(Food $food): void;

    public function getAll(): array;

    public function search(string $query): array;
}

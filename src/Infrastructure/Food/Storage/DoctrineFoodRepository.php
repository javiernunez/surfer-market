<?php

namespace App\Infrastructure\Food\Storage;

use App\Domain\Food\Food;
use App\Domain\Food\FoodRepositoryInterface;
use App\Domain\Food\Fruit\Fruit;
use App\Domain\Food\Vegetable\Vegetable;
use Doctrine\ORM\EntityManagerInterface;

readonly class DoctrineFoodRepository implements FoodRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(Food $food): void
    {
        $this->entityManager->persist($food);
        $this->entityManager->flush();
    }

    public function search(string $query): array
    {
        return [];
    }

    public function getAll(): array
    {
        $vegetables = $this->entityManager->getRepository(Vegetable::class)->findAll();
        $fruits = $this->entityManager->getRepository(Fruit::class)->findAll();

        return array_merge($fruits, $vegetables);
    }
}

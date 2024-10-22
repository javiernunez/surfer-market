<?php

namespace App\Infrastructure\Food\Storage;

use App\Domain\Food\Food;
use App\Domain\Food\FoodCollection;
use App\Domain\Food\FoodRepositoryInterface;
use App\Domain\Food\Fruit\Fruit;
use App\Domain\Food\Vegetable\Vegetable;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;

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

    public function search(array $filters): FoodCollection
    {
        $fruits = [];
        $vegetables = [];

        if (isset($filters['type'])) {
            if ($filters['type'] === 'fruit') {
                $fruits = $this->searchFruits($filters);
            } elseif ($filters['type'] === 'vegetable') {
                $vegetables = $this->searchVegetables($filters);
            } else {
                throw new InvalidArgumentException('Invalid type specified.');
            }
        } else {
            $fruits = $this->searchFruits($filters);
            $vegetables = $this->searchVegetables($filters);
        }

        return new FoodCollection(array_merge($fruits, $vegetables));
    }

    private function searchFruits(array $filters): array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('f')
            ->from(Fruit::class, 'f');

        // Apply additional filters for fruits
        if (isset($filters['name'])) {
            $qb->andWhere('f.name LIKE :name')
                ->setParameter('name', '%' . $filters['name'] . '%');
        }

        if (isset($filters['quantityInGrams'])) {
            $qb->andWhere('f.grams >= :quantity')
                ->setParameter('quantity', $filters['quantityInGrams']);
        }

        return $qb->getQuery()->getResult();
    }

    private function searchVegetables(array $filters): array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('f')
            ->from(Vegetable::class, 'f');

        // Apply additional filters for vegetables
        if (isset($filters['name'])) {
            $qb->andWhere('f.name LIKE :name')
                ->setParameter('name', '%' . $filters['name'] . '%');
        }

        if (isset($filters['quantityInGrams'])) {
            $qb->andWhere('f.grams >= :quantity')
                ->setParameter('quantity', $filters['quantityInGrams']);
        }

        return $qb->getQuery()->getResult();
    }
    public function getAll(): FoodCollection
    {
        $vegetables = $this->entityManager->getRepository(Vegetable::class)->findAll();
        $fruits = $this->entityManager->getRepository(Fruit::class)->findAll();

        return new FoodCollection(array_merge($fruits, $vegetables));
    }
}

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
        $qb = $this->entityManager->createQueryBuilder();

        if (isset($filters['type'])) {
            if ($filters['type'] === 'fruit') {
                $qb->select('f')
                    ->from(Fruit::class, 'f');
            } elseif ($filters['type'] === 'vegetable') {
                $qb->select('f')
                    ->from(Vegetable::class, 'f');
            } else {
                throw new InvalidArgumentException('Invalid type specified.');
            }
        } else {
            throw new InvalidArgumentException('Type filter is required.');
        }

        if (isset($filters['name'])) {
            $qb->andWhere('f.name LIKE :name')
                ->setParameter('name', '%' . $filters['name'] . '%');
        }

        if (isset($filters['quantity'])) {
            $qb->andWhere('f.grams >= :quantity')
                ->setParameter('quantity', $filters['quantity']);
        }

        return new FoodCollection($qb->getQuery()->getResult());
    }

    public function getAll(): FoodCollection
    {
        $vegetables = $this->entityManager->getRepository(Vegetable::class)->findAll();
        $fruits = $this->entityManager->getRepository(Fruit::class)->findAll();

        return new FoodCollection(array_merge($fruits, $vegetables));
    }
}

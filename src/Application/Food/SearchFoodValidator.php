<?php

namespace App\Application\Food;

use InvalidArgumentException;

class SearchFoodValidator
{
    public function validate(array $filters): void
    {
        if (isset($filters['type']) && !in_array($filters['type'], ['fruit', 'vegetable'])) {
            throw new InvalidArgumentException('Type must be either "fruit" or "vegetable".');
        }

        if (isset($filters['quantityInGrams'])) {
            if (is_string($filters['quantityInGrams']) && is_numeric($filters['quantityInGrams'])) {
                $filters['quantityInGrams'] = (int)$filters['quantityInGrams'];
            }
            if (!is_int($filters['quantityInGrams']) || $filters['quantityInGrams'] < 0) {
                throw new InvalidArgumentException('Quantity in grams must be a non-negative integer.');
            }
        }

        if (isset($filters['name']) && (!is_string($filters['name']) || empty($filters['name']))) {
            throw new InvalidArgumentException('Name must be a non-empty string.');
        }
    }
}

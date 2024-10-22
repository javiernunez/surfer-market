<?php

namespace App\Application\Food;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class SearchFoodValidatorTest extends TestCase
{
    private SearchFoodValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new SearchFoodValidator();
    }

    public function testValidFilters(): void
    {
        $filters = [
            'type' => 'fruit',
            'quantityInGrams' => 100,
            'name' => 'Apple',
        ];

        $this->validator->validate($filters); // Should not throw an exception
        $this->assertTrue(true); // If no exception, the test passes
    }

    public function testInvalidTypeThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Type must be either "fruit" or "vegetable".');

        $filters = ['type' => 'invalidType'];
        $this->validator->validate($filters);
    }

    public function testNegativeQuantityThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Quantity in grams must be a non-negative integer.');

        $filters = ['quantityInGrams' => -10];
        $this->validator->validate($filters);
    }

    public function testNonIntegerQuantityThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Quantity in grams must be a non-negative integer.');

        $filters = ['quantityInGrams' => 'ten'];
        $this->validator->validate($filters);
    }

    public function testEmptyNameThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Name must be a non-empty string.');

        $filters = ['name' => ''];
        $this->validator->validate($filters);
    }

    public function testNonStringNameThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Name must be a non-empty string.');

        $filters = ['name' => 123];
        $this->validator->validate($filters);
    }
}

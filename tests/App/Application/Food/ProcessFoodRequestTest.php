<?php

namespace App\Application\Food;

use App\Domain\Food\FoodRepositoryInterface;
use App\Domain\Misc\Enum\Unit;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ProcessFoodRequestTest extends TestCase
{
    private FoodRepositoryInterface $foodRepository;
    private ProcessFoodRequest $processFoodRequest;
    private ProcessFoodRequestValidator $processFoodRequestValidator;

    protected function setUp(): void
    {
        $this->foodRepository = $this->createMock(FoodRepositoryInterface::class);
        $this->processFoodRequestValidator = new ProcessFoodRequestValidator();
        $this->processFoodRequest = new ProcessFoodRequest(
            $this->foodRepository,
            $this->processFoodRequestValidator
        );
    }

    public function testInvokeWithValidData()
    {
        $foodItems = [
            [
                'id' => 1,
                'name' => 'Apple',
                'type' => 'fruit',
                'quantity' => 10,
                'unit' => 'g'
            ],
            [
                'id' => 2,
                'name' => 'Carrot',
                'type' => 'vegetable',
                'quantity' => 10,
                'unit' => 'kg'
            ]
        ];

        $this->foodRepository->expects($this->exactly(2))
            ->method('save');

        $this->processFoodRequest->__invoke($foodItems);
    }

    public function testInvokeWithMissingFields()
    {
        $foodItems = [
            [
                'id' => 3,
                'name' => 'Banana',
                // 'type' => 'fruit', // Missing type
                'grams' => 'kg'
            ],
            [
                'id' => 4,
                'name' => 'Tomato',
                'type' => 'vegetable',
                'grams' => 'kg'
            ]
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->processFoodRequest->__invoke($foodItems);
    }

    public function testInvokeWithInvalidType()
    {
        $foodItems = [
            [
                'id' => 5,
                'name' => 'Cucumber',
                'type' => 'invalid', // Invalid type
                'grams' => 123
            ]
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->processFoodRequest->__invoke($foodItems);
    }

    public function testInvokeWithEmptyArray()
    {
        $foodItems = [];

        $this->foodRepository->expects($this->never())
            ->method('save');

        $this->processFoodRequest->__invoke($foodItems);
    }
}

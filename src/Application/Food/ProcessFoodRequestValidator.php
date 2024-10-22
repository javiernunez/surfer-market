<?php

namespace App\Application\Food;

use InvalidArgumentException;

class ProcessFoodRequestValidator
{
    private array $requiredFields = [
        'id' => 'int',
        'name' => 'string',
        'type' => 'enum',
        'quantity' => 'int',
        'unit' => 'enum',
    ];

    public function validate(array $item): void
    {
        foreach ($this->requiredFields as $field => $type) {
            if (!array_key_exists($field, $item)) {
                throw new InvalidArgumentException("Missing required field: $field.");
            }

            $value = $item[$field];

            switch ($type) {
                case 'int':
                    if (!is_int($value)) {
                        throw new InvalidArgumentException("$field must be an integer.");
                    }
                    break;

                case 'string':
                    if (!is_string($value) || empty($value)) {
                        throw new InvalidArgumentException("$field must be a non-empty string.");
                    }
                    break;

                case 'enum':
                    if ($field === 'type' && !in_array($value, ['fruit', 'vegetable'])) {
                        throw new InvalidArgumentException("$field must be either 'fruit' or 'vegetable'.");
                    }
                    if ($field === 'unit' && !in_array($value, ['g', 'kg'])) {
                        throw new InvalidArgumentException("$field must be either 'g' or 'kg'.");
                    }
                    break;
            }
        }
    }
}

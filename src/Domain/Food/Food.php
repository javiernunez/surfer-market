<?php

namespace App\Domain\Food;

use App\Domain\Food\Fruit\Fruit;
use App\Domain\Misc\Enum\Unit;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Column;
use JsonSerializable;

#[MappedSuperclass]
abstract class Food implements JsonSerializable {

    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    protected int $id;

    #[Column(type: 'string')]
    protected string $name;

    #[Column(type: 'integer')]
    protected int $grams;

    private function __construct(int $id, string $name, int $grams) {
        $this->id = $id;
        $this->name = $name;
        $this->grams = $grams;
    }

    public static function create(int $id, string $name, int $quantity, Unit $unit): static {
        if($unit === Unit::KILOGRAM) {
            $quantity *= 1000;
        }
        return new static($id, $name, $quantity);
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'grams' => $this->grams,
            'type' => static::class === Fruit::class ? 'fruit' : 'vegetable',
        ];
    }
}

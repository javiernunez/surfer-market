<?php

namespace App\Domain\Food;

use App\Domain\Global\Enum\Unit;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Column;

#[MappedSuperclass]
abstract class Food {

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
}

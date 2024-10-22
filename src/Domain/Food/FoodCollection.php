<?php

namespace App\Domain\Food;


class FoodCollection
{
    private array $items = [];

    public function add(Food $food): void
    {
        $this->items[] = $food;
    }

    public function remove(Food $food): void
    {
        unset($this->items[$food->getId()]);
    }

    public function list(): array
    {
        return $this->items;
    }
}

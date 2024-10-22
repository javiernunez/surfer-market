<?php

namespace App\Domain\Food\Fruit;

use App\Domain\Food\Food;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'fruits')]
class Fruit extends Food
{

}

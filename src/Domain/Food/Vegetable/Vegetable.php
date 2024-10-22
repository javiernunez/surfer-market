<?php

namespace App\Domain\Food\Vegetable;

use App\Domain\Food\Food;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'vegetables')]
class Vegetable extends Food
{

}

<?php

namespace App\DataFixtures;

use App\Entity\Todo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TodoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $todo = new Todo;
            $todo->setName("Todo $i");
            $todo->setDescription("This is my todo");
            $todo->setCategory("Category 123");
            $todo->setPriority(rand(1,5));
            $todo->setDueDate(\DateTime::createFromFormat('Y-m-d','2022-04-30'));
            $manager->persist($todo);
        }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Laptop;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class LaptopFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $laptop = new Laptop;
            $laptop->setName("XPS $i");
            $laptop->setBrand("Dell");
            $laptop->setPrice((float)(rand(1000,2000)));
            $laptop->setQuantity(rand(10,30));
            $laptop->setDate(\DateTime::createFromFormat('Y-m-d','2022-03-06'));
            $laptop->setImage("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHnB4T7H4JzhBwDR2d-bYrCfL_KkZQ0Y72TCFhliqA-oKyoZ6Jhe7XPWcMEpEKdQrRjaY&usqp=CAU");
            $manager->persist($laptop);
        }

        $manager->flush();
    }
}

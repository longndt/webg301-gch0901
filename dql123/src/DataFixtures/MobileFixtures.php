<?php

namespace App\DataFixtures;

use App\Entity\Mobile;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class MobileFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $mobile = new Mobile;
            $mobile->setName("Mobile $i");
            $mobile->setQuantity(rand(10,30));
            $mobile->setPrice(999.99);
            $mobile->setImage("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTa-DBtc1Mhrt4CR4ylnTV7_DzUGQgI_rwqmA&usqp=CAU");
            $manager->persist($mobile);
        }

        $manager->flush();
    }
}

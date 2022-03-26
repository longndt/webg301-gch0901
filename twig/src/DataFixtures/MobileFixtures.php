<?php

namespace App\DataFixtures;

use App\Entity\Mobile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MobileFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $mobile = new Mobile;
            $mobile->setName("Mobile $i");
            $mobile->setPrice((float)rand(500,1200));
            $mobile->setImage("https://image.oppo.com/content/dam/oppo/common/mkt/v2-2/reno6pro-5g-oversea/listpage/Phone-List-Page-product-list-Aurora-427-x-600.png");
            $manager->persist($mobile);
        }

        $manager->flush();
    }
}

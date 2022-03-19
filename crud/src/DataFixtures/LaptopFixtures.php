<?php

namespace App\DataFixtures;

use App\Entity\Laptop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LaptopFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //tạo vòng lặp for để add nhiều object cùng lúc
        for ($i=1; $i<=20; $i++) {
            //tạo 1 object laptop mới
            $laptop = new Laptop;
            //dùng setter của entity để add thông tin cho object Laptop
            $laptop->setName("Macbook $i");
            $laptop->setQuantity(rand(10,90)); //rand: random từ giá trị min đến max
            $laptop->setPrice((float)(rand(1000,1500)));
            $laptop->setImage("https://macone.vn/wp-content/uploads/2020/11/macbook-pro-silver-m1-2020.jpeg");
            //add object laptop vào DB
            $manager->persist($laptop);
        }
        //confirm thao tác add object
        $manager->flush();

        
    }
}

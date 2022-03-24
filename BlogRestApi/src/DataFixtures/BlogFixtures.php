<?php

namespace App\DataFixtures;

use App\Entity\Blog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $blog = new Blog;
            $blog->setAuthor("Tuan Hung");
            $blog->setTitle("Blog $i");
            $blog->setContent("University of Greenwich - Vietnam");
            $blog->setDate(\DateTime::createFromFormat('Y-m-d','2022-03-24'));
            $manager->persist($blog);
        }

        $manager->flush();
    }
}

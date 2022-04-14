<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $book = new Book;
            $book->setAuthor("Author $i");
            $book->setTitle("Book Title $i");
            $book->setDate(\DateTime::createFromFormat('Y-m-d','2022-02-08'));
            $book->setPrice(100);
            $book->setImage("https://marketplace.canva.com/EAD7WuSVrt0/1/0/1003w/canva-colorful-illustration-young-adult-book-cover-LVthABb24ik.jpg");
            $manager->persist($book);
        }

        $manager->flush();
    }
}

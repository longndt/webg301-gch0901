<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=3; $i++) {
            $genre = new Genre;
            $genre->setName("Science $i");
            $genre->setDescription("Science book for students");
            $genre->setImage("https://thumbs.dreamstime.com/z/science-books-shelf-open-book-glasses-lettering-science-books-shelf-open-book-glasses-lettering-white-135179577.jpg");
            $manager->persist($genre);
        }

        $manager->flush();
    }
}

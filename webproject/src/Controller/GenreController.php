<?php

namespace App\Controller;

use App\Entity\Genre;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/genre')]
class GenreController extends AbstractController
{
   #[Route('/', name: 'genre_index')]
   public function genreIndex (ManagerRegistry $registry) {
       $genres = $registry->getRepository(Genre::class)->findAll();
       return $this->render("genre/index.html.twig",
       [
           'genres' => $genres
       ]);
   }

   #[Route('/detail/{id}', name: 'genre_detail')]
   public function genreDetail (ManagerRegistry $registry, $id) {
       $genre = $registry->getRepository(Genre::class)->find($id);
       if ($genre == null) {
           $this->addFlash("Error","Genre not found !");
           return $this->redirectToRoute("genre_index");
       }
       return $this->render("genre/detail.html.twig",
       [
           'genre' => $genre
       ]);
   }

   #[Route('/delete/{id}', name: 'genre_delete')]
   public function genreDelete (ManagerRegistry $registry, $id) {
       $genre = $registry->getRepository(Genre::class)->find($id);
       if ($genre == null) {
           $this->addFlash("Error", "Genre not found !");
       } else {
            $manager = $registry->getManager();
            $manager->remove($genre);
            $manager->flush();
            $this->addFlash("Success", "Delete genre succeed !");
       }
       return $this->redirectToRoute("genre_index");
   }

}

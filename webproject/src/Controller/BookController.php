<?php

namespace App\Controller;

use App\Entity\Book;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route("/book")]
class BookController extends AbstractController
{
    #[Route('/', name: 'book_index')]
    public function bookIndex (ManagerRegistry $registry) {
        $books = $registry->getRepository(Book::class)->findAll();
        return $this->render("book/index.html.twig",
        [
            'books' => $books
        ]);
    }
 
    #[Route('/detail/{id}', name: 'book_detail')]
    public function bookDetail (ManagerRegistry $registry, $id) {
        $book = $registry->getRepository(Book::class)->find($id);
        if ($book == null) {
            $this->addFlash("Error","Book not found !");
            return $this->redirectToRoute("book_index");
        }
        return $this->render("book/detail.html.twig",
        [
            'book' => $book
        ]);
    }
}

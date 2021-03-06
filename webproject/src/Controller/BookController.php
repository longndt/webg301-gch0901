<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Genre;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

use function PHPUnit\Framework\throwException;

#[Route("/book")]
class BookController extends AbstractController
{
    #[Route('/', name: 'book_index')]
    public function bookIndex (ManagerRegistry $registry) {
        $books = $registry->getRepository(Book::class)->findAll();
        $genres = $registry->getRepository(Genre::class)->findAll();
        return $this->render("book/index.html.twig",
        [
            'books' => $books,
            'genres' => $genres
        ]);
    }
 
    #[Route('/detail/{id}', name: 'book_detail')]
    public function bookDetail (ManagerRegistry $registry, $id) {
        $book = $registry->getRepository(Book::class)->find($id);
        $genres = $registry->getRepository(Genre::class)->findAll();
        if ($book == null) {
            $this->addFlash("Error","Book not found !");
            return $this->redirectToRoute("book_index");
        }
        return $this->render("book/detail.html.twig",
        [
            'book' => $book,
            'genres' => $genres
        ]);
    }

    #[Route('/delete/{id}', name: 'book_delete')]
    public function bookDelete (ManagerRegistry $registry, $id) {
        $book = $registry->getRepository(Book::class)->find($id);
        $genres = $registry->getRepository(Genre::class)->findAll();
        if ($book == null) {
            $this->addFlash("Error","Book not found !");
        } else {
            $manager = $registry->getManager();
            $manager->remove($book);
            $manager->flush();
            $this->addFlash("Success", "Book delete succeed !");
        }
        return $this->redirectToRoute("book_index",
                        [
                            'genres' => $genres
                        ]);
    }

    #[Route('/add', name: 'book_add')]
   public function bookAdd(Request $request, ManagerRegistry $registry) {
       $genres = $registry->getRepository(Genre::class)->findAll();
       $book = new Book;
       $form = $this->createForm(BookType::class,$book);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           //code x??? l?? t??n ???nh v?? copy ???nh v??o th?? m???c ch???a project
           //B1: t???o bi???n $image ????? l???y ra t??n image khi upload t??? form
           $image = $book->getImage(); 
           //B2: t???o t??n file ???nh m???i => ?????m b???o t??n ???nh l?? duy nh???t
           $imgName = uniqid(); //unique id
           //B3: l???y ra ??u??i (extension) c???a ???nh
           $imgExtension = $image->guessExtension();
           //Note: c???n b??? data type "string" trong h??m getImage() + setImage()
           //????? bi???n $image th??nh object thay v?? string
           //B4: gh??p th??nh t??n file ???nh ho??n thi???n
           $imageName = $imgName . '.' . $imgExtension;
           //B5: copy ???nh v??o th?? m???c ch??? ?????nh trong project
           try {
             $image->move(
                $this->getParameter('book_image'),$imageName
             );
           //Note: c???n set ???????ng d???n ch???a ???nh trong file config/services.yaml  
           } catch (FileException $e) {
               throwException($e);
           }
           //B6: l??u t??n ???nh v??o DB
           $book->setImage($imageName);
           //?????y d??? li???u c???a book v??o DB
           $manager = $registry->getManager();
           $manager->persist($book);
           $manager->flush();
           $this->addFlash("Success","Add book succeed !");
           return $this->redirectToRoute('book_index');
       }
       return $this->renderForm('book/add.html.twig',
                                [
                                  'bookForm' => $form,
                                  'genres' => $genres
                                ]);
   }

   #[Route('/edit/{id}', name: 'book_edit')]
   public function bookEdit(Request $request, ManagerRegistry $registry, $id) {
      $genres = $registry->getRepository(Genre::class)->findAll();
       $book = $registry->getRepository(Book::class)->find($id);
       $form = $this->createForm(BookType::class, $book);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           /* 
           ki???m tra xem ng?????i d??ng c?? upload ???nh m???i
           cho book khi edit ???nh hay kh??ng
           n???u c?? th?? ch???y code x??? l?? ???nh gi???ng ph???n Add 
           n???u kh??ng th?? gi??? nguy??n ???nh c?? trong DB
           */
           $imageFile = $form['image']->getData();
           if ($imageFile != null) {
               $image = $book->getImage();
               $imgName = uniqid();
               $imgExtension = $image->guessExtension();
               $imageName = $imgName . '.' . $imgExtension;
               try {
                   $image->move(
                       $this->getParameter('book_image'),
                       $imageName
                   );
               } catch (FileException $e) {
                   throwException($e);
               }
               $book->setImage($imageName);
           }

           $manager = $registry->getManager();
           $manager->persist($book);
           $manager->flush();
           $this->addFlash("Success", "Edit book succeed !");
           return $this->redirectToRoute('book_index');
       }
       return $this->renderForm('book/edit.html.twig',
                                [
                                    'bookForm' => $form,
                                    'genres' => $genres
                                ]);
   }

   #[Route('/asc', name: 'book_asc')]
   public function sortAsc(BookRepository $bookRepository, ManagerRegistry $registry) {
      $genres = $registry->getRepository(Genre::class)->findAll();
       $books = $bookRepository->sortBookAsc();
       return $this->render("book/index.html.twig",
                            [
                                'books' => $books,
                                'genres' => $genres
                            ]);
   }

   #[Route('/desc', name: 'book_desc')]
   public function sortDesc(BookRepository $bookRepository, ManagerRegistry $registry) {
      $genres = $registry->getRepository(Genre::class)->findAll();
       $books = $bookRepository->sortBookDesc();
       return $this->render("book/index.html.twig",
                            [
                                'books' => $books,
                                'genres' => $genres
                            ]);
   }

   #[Route('/search', name: 'book_search')]
   public function search (Request $request, BookRepository $bookRepository, ManagerRegistry $registry) {
       $genres = $registry->getRepository(Genre::class)->findAll();
       $keyword = $request->get('title');
       $books = $bookRepository->search($keyword);
       return $this->render("book/index.html.twig",
                            [
                                'books' => $books,
                                'genres' => $genres
                            ]);
   }

   #[Route('/filter/{id}', name: 'book_filter')]
   public function filter ($id, ManagerRegistry $registry) {
       $genres = $registry->getRepository(Genre::class)->findAll();
       $genre = $registry->getRepository(Genre::class)->find($id);
       $books = $genre->getBooks();
       return $this->render("book/index.html.twig",
                            [
                                    'books' => $books,
                                    'genres' => $genres
                            ]);
   }
}

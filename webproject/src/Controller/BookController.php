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
           //code xử lý tên ảnh và copy ảnh vào thư mục chứa project
           //B1: tạo biến $image để lấy ra tên image khi upload từ form
           $image = $book->getImage(); 
           //B2: tạo tên file ảnh mới => đảm bảo tên ảnh là duy nhất
           $imgName = uniqid(); //unique id
           //B3: lấy ra đuôi (extension) của ảnh
           $imgExtension = $image->guessExtension();
           //Note: cần bỏ data type "string" trong hàm getImage() + setImage()
           //để biển $image thành object thay vì string
           //B4: ghép thành tên file ảnh hoàn thiện
           $imageName = $imgName . '.' . $imgExtension;
           //B5: copy ảnh vào thư mục chỉ định trong project
           try {
             $image->move(
                $this->getParameter('book_image'),$imageName
             );
           //Note: cần set đường dẫn chứa ảnh trong file config/services.yaml  
           } catch (FileException $e) {
               throwException($e);
           }
           //B6: lưu tên ảnh vào DB
           $book->setImage($imageName);
           //đẩy dữ liệu của book vào DB
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

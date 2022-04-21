<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/genre')]
/**
 * @IsGranted("ROLE_STAFF")
 */
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
       }
       //check xem genre cần xóa có tồn tại tối thiểu 1 book hay không
       //nếu có thì không cho xóa và thông báo lỗi
       else if (count($genre->getBooks()) >= 1) {
           $this->addFlash("Error", "Can not delete this genre !");
       }
       else {
            $manager = $registry->getManager();
            $manager->remove($genre);
            $manager->flush();
            $this->addFlash("Success", "Delete genre succeed !");
       }
       return $this->redirectToRoute("genre_index");
   }

   #[Route('/add', name: 'genre_add')]
   public function genreAdd(Request $request, ManagerRegistry $registry) {
       $genre = new Genre;
       $form = $this->createForm(GenreType::class,$genre);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $manager = $registry->getManager();
           $manager->persist($genre);
           $manager->flush();
           $this->addFlash("Success","Add genre succeed !");
           return $this->redirectToRoute('genre_index');
       }
       return $this->renderForm('genre/add.html.twig',
                                [
                                  'genreForm' => $form  
                                ]);
   }

   #[Route('/edit/{id}', name: 'genre_edit')]
   public function genreEdit(Request $request, ManagerRegistry $registry, $id) {
       $genre = $registry->getRepository(Genre::class)->find($id);
       $form = $this->createForm(GenreType::class, $genre);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $manager = $registry->getManager();
           $manager->persist($genre);
           $manager->flush();
           $this->addFlash("Success", "Edit genre succeed !");
           return $this->redirectToRoute('genre_index');
       }
       return $this->renderForm('genre/edit.html.twig',
                                [
                                    'genreForm' => $form
                                ]);
   }
}

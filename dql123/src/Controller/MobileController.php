<?php

namespace App\Controller;

use App\Entity\Mobile;
use App\Form\MobileType;
use App\Repository\MobileRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mobile')]
class MobileController extends AbstractController
{
    // SELECT * FROM Mobile (ORDER BY id ASC) : oldest => newest
     #[Route('/', name: 'mobile_index')]
     public function viewMobileList (ManagerRegistry $doctrine) {
         $mobiles = $doctrine->getRepository(Mobile::class)->findAll();
         return $this->render('mobile/index.html.twig',
                                [
                                    'mobiles' => $mobiles
                                ]);
     }
     // SELECT * FROM Mobile ORDER BY id DESC : newest => oldest
     #[Route('/sort', name: 'mobile_desc')]
     public function sortMobileByIdDesc (MobileRepository $mobileRepository) {
        $mobiles = $mobileRepository->sortId();
        return $this->render('mobile/index.html.twig',
                                [
                                    'mobiles' => $mobiles
                                ]);
     }

     //DELETE FROM Mobile WHERE id = '$id'
     #[Route('/delete/{id}', name: 'mobile_delete')]
     public function deleteMobile (ManagerRegistry $doctrine, $id) {
        $mobile = $doctrine->getRepository(Mobile::class)->find($id);
        $manager = $doctrine->getManager();
        $manager->remove($mobile);
        $manager->flush();
        $this->addFlash('Success','Delete mobile succeed !');
        return $this->redirectToRoute('mobile_desc');
     }

     #[Route('/asc', name: 'quantity_asc')]
     public function sortQuantityAsc (MobileRepository $mobileRepository) {
        $mobiles = $mobileRepository->sortQuantityAsc();
        return $this->render('mobile/index.html.twig',
                                [
                                    'mobiles' => $mobiles
                                ]);
     }

     #[Route('/desc', name: 'quantity_desc')]
     public function sortQuantityDesc (MobileRepository $mobileRepository) {
        $mobiles = $mobileRepository->sortQuantityDesc();
        return $this->render('mobile/index.html.twig',
                                [
                                    'mobiles' => $mobiles
                                ]);
     }

     #[Route('/search', name: 'mobile_search')]
     public function searchMobile (MobileRepository $mobileRepository, Request $request) {
         $name = $request->get('keyword');
         $mobiles = $mobileRepository->searchByName($name);
         //nếu kết quả tìm kiếm rỗng thì đẩy thông báo lỗi về view
         if ($mobiles == null) {
            $this->addFlash('Error','Mobile not found !');
         }
         return $this->render('mobile/index.html.twig',
                                [
                                    'mobiles' => $mobiles
                                ]);
     }

     #[Route('/add', name: 'mobile_add')]
     public function addMobile (Request $request, ManagerRegistry $doctrine) {
         $mobile = new Mobile;
         $form = $this->createForm(MobileType::class,$mobile);
         $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($mobile);
            $manager->flush();
            $this->addFlash("Success","Add new mobile succeed !");
            return $this->redirectToRoute('mobile_desc');
         }
         return $this->renderForm('mobile/add.html.twig',
                                [
                                    'mobileForm' => $form
                                ]);
     }
}

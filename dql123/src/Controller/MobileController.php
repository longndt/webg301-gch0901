<?php

namespace App\Controller;

use App\Entity\Mobile;
use App\Repository\MobileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MobileController extends AbstractController
{
    // SELECT * FROM Mobile (ORDER BY id ASC) : oldest => newest
     #[Route('/', name: 'mobile_index')]
     public function viewMobileList () {
         $mobiles = $this->getDoctrine()->getRepository(Mobile::class)->findAll();
         return $this->render('mobile/index.html.twig',
                                [
                                    'mobiles' => $mobiles
                                ]);
     }
     // SELECT * FROM Mobile ORDER BY id DESC : newest => oldest
     #[Route('/sort', name: 'mobile_desc')]
     public function sortMobileByIdDesc (MobileRepository $mobileRepository) {
        $mobiles = $mobileRepository->sort();
        return $this->render('mobile/index.html.twig',
                                [
                                    'mobiles' => $mobiles
                                ]);
     }

     //DELETE FROM Mobile WHERE id = '$id'
     #[Route('/delete/{id}', name: 'mobile_delete')]
     public function deleteMobile ($id) {
        $mobile = $this->getDoctrine()->getRepository(Mobile::class)->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($mobile);
        $manager->flush();
        return $this->redirectToRoute('mobile_desc');
     }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
   #[Route('/test1', name: 'test1')]
   public function test1 () {
       //render ra file view test1.html trong thư mục test của template
       return $this->render("test/test1.html");
   }

   #[Route('/test2', name: 'test2')]
   public function test2 () {
       $school = "University of Greenwich - Vietnam";
       $year = 2022;
       $sports = array("Football", "Badminton", "Basketball", "Golf");
       $car = "https://danviet.mediacdn.vn/thumb_w/650/2020/8/17/2-14-15976802102061066215241.jpg";
       //render ra file twig và gửi kèm dữ liệu trong []
       return $this->render("test/test2.html.twig",
                [
                    's' => $school,
                    'y' => $year,
                    'm' => 'iPhone 13 Pro Max',
                    'sports' => $sports,
                    'car' => $car
                ]);
   }

   #[Route('/test3', name: 'test3')]
   public function test3 () {
       $numbers = array(1,2,3,4,5,6,7,8,9,10);
       return $this->render("test/test3.html.twig",
                            [
                                'numbers' => $numbers
                            ]);
   }
  

}

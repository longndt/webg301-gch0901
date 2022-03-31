<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
     #[Route('/', name: 'homepage')]
     public function homepage() {
         return $this->render("demo/home.html.twig");
     }

     #[Route('/demo', name: 'demo')]
     public function demo() {
         return $this->render("demo/demo.html.twig");
     }

     #[Route('/demo1', name: 'demo1')]
     public function demo1() {
         $name = "Nguyen Van A";
         $id = "GCH123456";
         $email = "gch123456@fpt.edu.vn";
         return $this->render("demo/demo1.html.twig",
                            [
                                'ten' => $name,
                                'masv' => $id,
                                'thu' => $email
                            ]);
     }
}

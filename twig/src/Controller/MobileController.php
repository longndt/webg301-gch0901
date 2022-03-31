<?php

namespace App\Controller;

use App\Entity\Mobile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MobileController extends AbstractController
{
    #[Route('/mobile', name: 'mobile_list')]
    public function viewAllMobile () {
        //lấy dữ liệu từ bảng Mobile và lưu vào array $mobiles
        $mobiles = $this->getDoctrine()->getRepository(Mobile::class)->findAll();
        //render ra file view tương ứng cùng với dữ liệu từ $mobiles
        return $this->render("mobile/list.html.twig",
                            [
                                'mobiles' => $mobiles
                            ]);
    }
}

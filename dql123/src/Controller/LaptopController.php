<?php

namespace App\Controller;

use App\Entity\Laptop;
use App\Repository\LaptopRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/laptop')]
class LaptopController extends AbstractController
{
    #[Route('/', name: 'laptop_index')]  
    public function laptopIndex(ManagerRegistry $doctrine, LaptopRepository $laptopRepository ) {
        //Cách 1: dùng method findAll() mặc định trong Repository
        //SQL: SELECT * FROM Laptop (ORDER BY id ASC)
        //$laptops = $doctrine->getRepository(Laptop::class)->findAll();
        
        //Cách 2: dùng method tự tạo bằng DQL trong Repository
        //SQL: SELECT * FROM Laptop ORDER BY id DESC
        $laptops = $laptopRepository->viewAllLaptop();
        return $this->render("laptop/index.html.twig",
        [
            'laptops' => $laptops
        ]);
    }
}

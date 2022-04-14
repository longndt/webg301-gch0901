<?php

namespace App\Controller;

use App\Entity\Laptop;
use App\Form\LaptopType;
use App\Repository\LaptopRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/add', name: 'laptop_add')]
    public function laptopAdd (Request $request, ManagerRegistry $doctrine) {
        $laptop = new Laptop;
        $form = $this->createForm(LaptopType::class,$laptop);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($laptop);
            $manager->flush();
            $this->addFlash("Success","Add laptop succeed !");
            return $this->redirectToRoute("laptop_index");
        }
        return $this->renderForm("laptop/add.html.twig",
                                [
                                    'laptopForm' => $form
                                ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LaptopController extends AbstractController
{
    #[Route('/laptop', name: 'app_laptop')]
    public function index(): Response
    {
        return $this->render('laptop/index.html.twig', [
            'controller_name' => 'LaptopController',
        ]);
    }
}

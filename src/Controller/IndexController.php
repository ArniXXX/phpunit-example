<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param ProductRepository $productRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ProductRepository $productRepository)
    {
        return $this->render('index/index.html.twig', [
            'showcase' => $productRepository->findShowcase(),
        ]);
    }
}

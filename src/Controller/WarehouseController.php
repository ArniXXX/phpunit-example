<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\WarehouseType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WarehouseController extends AbstractController
{
    /**
     * @Route("/warehouse", name="warehouse")
     * @param ProductRepository $productRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ProductRepository $productRepository)
    {
        return $this->render('warehouse/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/warehouse/edit/{id}", name="warehouse_edit")
     * @param int $id
     * @param ProductRepository $productRepository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function add(int $id = 0, ProductRepository $productRepository, Request $request)
    {
        if (!$product = $productRepository->find($id)) {
            $product =  new Product();
        }

        $productForm = $this->createForm(WarehouseType::class, $product, ['action' =>
            $this->generateUrl('product_save', ['id' => $product->getId()])
        ]);

        return $this->render('product/edit.html.twig', [
            'product_form' => $productForm->createView(),
        ]);
    }

    /**
     * @Route("/warehouse/save/{id}", name="warehouse_save")
     * @param int $id
     * @param ProductRepository $productRepository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function save(int $id = 0, ProductRepository $productRepository, Request $request)
    {
        if (!$product = $productRepository->find($id)) {
            $product =  new Product();
        }

        $productForm = $this->createForm(WarehouseType::class, $product);

        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $manager->persist($product);
            $manager->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Success!!!');

            return $this->redirectToRoute('product_edit', ['id' => $product->getId()], 301);
        } else {
            $this->get('session')->getFlashBag()->add('notice', 'Something wrong!!!');

            return $this->redirectToRoute('product_edit', ['id' => $product->getId()], 301);
        }
    }
}

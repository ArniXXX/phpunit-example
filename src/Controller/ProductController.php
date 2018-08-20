<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/show/{id}", name="product")
     * @param int $id
     * @param ProductRepository $productRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(int $id = 0, ProductRepository $productRepository)
    {
        if ($product = $productRepository->find($id)) {
            return $this->render('product/index.html.twig', [
                'product' => $product,
            ]);
        } else {
            throw $this->createNotFoundException('The page does not exist');
        }
    }

    /**
     * @Route("/product/list", name="product_list")
     * @param ProductRepository $productRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function products(ProductRepository $productRepository)
    {
        return $this->render('product/list.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/product/edit/{id}", name="product_edit")
     * @param int $id
     * @param ProductRepository $productRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function add(int $id = 0, ProductRepository $productRepository, Request $request)
    {
        if (!$product = $productRepository->find($id)) {
            $product =  new Product();
        }

        $productForm = $this->createForm(ProductType::class, $product, ['action' =>
            $this->generateUrl('product_save', ['id' => $product->getId()])
        ]);

        return $this->render('product/edit.html.twig', [
            'product_form' => $productForm->createView(),
        ]);
    }

    /**
     * @Route("/product/save/{id}", name="product_save")
     * @param int $id
     * @param ProductRepository $productRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function save(int $id = 0, ProductRepository $productRepository, Request $request)
    {
        if (!$product = $productRepository->find($id)) {
            $product =  new Product();
        }

        $productForm = $this->createForm(ProductType::class, $product);

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

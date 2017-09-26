<?php

namespace SampleBundle\Controller;

use SampleBundle\Entity\Category;
use SampleBundle\Entity\Product;
use SampleBundle\Form\Type\ProductType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ProductController extends Controller
{
    public function createProductAction(Request $request)
    {
        $category = new Category();
//        $category->setName('Computer Peripherals');

        $product = new Product();
//        $product->setName('Keyboard');
//        $product->setPrice(19.99);
//        $product->setDescription('Ergonomic and stylish!');

        // relate this product to the category
        $product->setCategory($category);
        
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $em = $this->getDoctrine()->getManager();
//            $em->persist($category);
//            $em->flush();
            $em->persist($product);
            $em->flush();

            return new Response($product);
        }
        return $this->render('SampleBundle:product:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

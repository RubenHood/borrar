<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use BackendBundle\Entity\Product;


class Api extends Controller
{
    //para convertir el json en informacion leíble
    public function serializeProduct(Product $product)
    {
        return array(
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'img' => $product->getImg(),
            'category' => $product->getCategory()
        );
    }

    public function result($clave, $valor = null)
    {
        return array($clave => $valor);
    }

    /**
     * @Route("/", methods={"GET"})
     */
    public function getAllProducts()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository(Product::class)->findAll();

        $data = array('products' => array());

        foreach ($products as $product) {
            $data['products'][] = $this->serializeProduct($product);
        }
        return new JsonResponse($data, 200);
    }
}

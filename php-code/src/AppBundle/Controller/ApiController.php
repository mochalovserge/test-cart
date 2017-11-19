<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Model\Cart;
use AppBundle\Model\Products;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

/**
 * Class ApiController
 * @package AppBundle\Controller
 * @author Mochalov Sergey <mochalov.serge@gmail.com>
 */
class ApiController extends FOSRestController
{
    /**
     * Get all products
     *
     * @Rest\Get("/api/products")
     * @param Products $products
     * @return mixed
     */
    public function productsAction(Products $products)
    {
        return $products->getAll();
    }

    /**
     * Add to cart
     *
     * @Rest\Post("/api/cart")
     * @param Request $request
     * @param Cart $cart
     * @param Product $entity
     */
    public function addToCartAction(Request $request, Cart $cart, Product $entity)
    {
        $entity->setId($request->get('id'));
        $entity->setQuantity($request->get('quantity'));

        $validator = $this->get('validator');
        $errors = $validator->validate($entity);

        if (count($errors)) {
            throw new HttpException(400, "New comment is not valid.");
        }

        $cart->add($request->get('id'), $request->get('quantity'));
    }

    /**
     * Get all products from cart
     *
     * @Rest\Get("/api/cart")
     * @param Cart $cart
     * @return array
     */
    public function getCartAction(Cart $cart)
    {
        return $cart->get();
    }

    /**
     * Delete product from cart
     *
     * @Rest\Delete("/api/cart/{id}")
     * @param $id
     * @param Cart $cart
     * @param Products $products
     * @return bool
     */
    public function deleteFromCartAction($id, Cart $cart, Products $products)
    {
        if (!$products->getById($id)) {
            throw new HttpException(404, "Такого продукта нет в системе.");
        }
        return $cart->delete($id);
    }
}

<?php

namespace AppBundle\Model;

/**
 * Class Products
 * @package Acme
 * @author Mochalov Sergey <mochalov.serge@gmail.com>
 */
class Products
{
    /**
     * @var array
     */
    protected $products = [
        [
            'id' => 1,
            'name' => 'Product #1',
            'description' => 'Product description',
            'price' => 55.25
        ],
        [
            'id' => 2,
            'name' => 'Product #2',
            'description' => 'Product description',
            'price' => 156.15
        ],
        [
            'id' => 3,
            'name' => 'Product #3',
            'description' => 'Product description',
            'price' => 256.9
        ],
    ];

    /**
     * Get all products
     *
     * @return array
     */
    public function getAll()
    {
        return $this->products;
    }

    /**
     * Get product by id
     *
     * @param $id
     * @return bool|mixed
     */
    public function getById($id)
    {
        if (($found_key = array_search($id, array_column($this->products, 'id'))) !== false) {
            return $this->products[$found_key];
        }

        return false;
    }
}

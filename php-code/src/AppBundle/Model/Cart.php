<?php

namespace AppBundle\Model;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class Cart
 * @package AppBundle\Model
 * @author Mochalov Sergey <mochalov.serge@gmail.com>
 */
class Cart
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @var Products
     */
    protected $products;

    /**
     * @var array
     */
    protected $carts = [];

    /**
     * Cart constructor.
     */
    public function __construct()
    {
        $this->session = new Session();

        $this->products = new Products();

        $this->carts = $this->session->get('carts', []);
    }

    /**
     * @param $id
     * @param $quantity
     * @return bool
     */
    public function add($id, $quantity)
    {
        if ($product = $this->products->getById($id)) {
            if (($fined_key = $this->search($id)) !== false) {

                $p = $this->carts['products'][$fined_key];

                $p['quantity'] += $quantity;
                $p['sum'] = $product['price'] * $p['quantity'];

                $this->carts['products'][$fined_key] = $p;
            } else {
                $p = [
                    'id' => $id,
                    'quantity' => $quantity,
                    'sum' => $product['price'] * $quantity,
                ];

                $this->carts['products'][] = $p;
            }
        }

        $this->refresh();

        return true;
    }

    /**
     *
     */
    protected function refresh()
    {
        $this->carts['products'] = array_values($this->carts['products']);
        $this->carts['products_count'] = $this->carts['total_sum'] = 0;

        foreach ($this->carts['products'] as $item) {
            $this->carts['products_count'] += $item['quantity'];
            $this->carts['total_sum'] += $item['sum'];
        }

        $this->session->set('carts', $this->carts);
    }

    /**
     * @param $id
     * @return false|int|string
     */
    public function search($id)
    {
        return array_search($id, array_column($this->carts['products'] ?? [], 'id'));
    }

    /**
     * Get all cart data
     *
     * @return array
     */
    public function get()
    {
        return [
            'data' => $this->carts,
        ];
    }


    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        if (($fined_key = $this->search($id)) !== false) {
            $product = $this->carts['products'][$fined_key];

            if ($product['quantity'] > 1) {
                $product['quantity']--;

                $this->carts['products'][$fined_key] = $product;
            } else {
                unset($this->carts['products'][$fined_key]);
            }
        }

        $this->refresh();

        return true;
    }
}

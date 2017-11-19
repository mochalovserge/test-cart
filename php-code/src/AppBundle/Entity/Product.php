<?php

namespace AppBundle\Entity;

use AppBundle\Model\Products;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class Product
 * @package AppBundle\Entity
 * @author Mochalov Sergey <mochalov.serge@gmail.com>
 */
class Product
{
    /**
     * @var int
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
    protected $id;

    /**
     * @var int
     * @Assert\Range(
     *     min = 1,
     *     max = 10,
     *     minMessage = "This value should be {{ limit }} or more",
     *     maxMessage = "This value should be {{ limit }} or less",
     *     invalidMessage = "This value should be a valid number"
     * )
     */
    protected $quantity;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (int)$quantity;
    }

    /**
     * @param ExecutionContextInterface $context
     * @param $payload
     *
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        $products = new Products();
        $id = $this->getId();

        $r=$products->getById($id);

        if (!$r) {
            $context->buildViolation("This product doesn't exist!")
                ->atPath('id')
                ->addViolation();
        }
    }
}
<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ShopBundle\Entity\Order;
use ShopBundle\Entity\Product;
use UserBundle\Entity\User;

/**
 * ProductOrder
 *
 * @ORM\Table(name="product_order")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\ProductOrderRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ProductOrder
{
    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Order")
     * @ORM\JoinColumn(nullable=true)
     */
    private $order;

    /**
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Product")
     * @ORM\JoinColumn(nullable=true)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $provider;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return ProductOrder
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set quantity.
     *
     * @param int $quantity
     *
     * @return ProductOrder
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Get price.
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price.
     *
     * @param int $price
     *
     * @return ProductOrder
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Set order.
     *
     * @param Order|null $order
     *
     * @return ProductOrder
     */
    public function setOrder(Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order.
     *
     * @return Order|null
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set product.
     *
     * @param Product|null $product
     *
     * @return ProductOrder
     */
    public function setProduct(Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product.
     *
     * @return Product|null
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set user.
     *
     * @param User|null $user
     *
     * @return ProductOrder
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set provider.
     *
     * @param User|null $provider
     *
     * @return ProductOrder
     */
    public function setProvider(User $provider = null)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider.
     *
     * @return User|null
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @ORM\PrePersist()
     */
    public function decreaseQuantity(){
        $this->product->setQuantity($this->product->getQuantity() - $this->quantity);
    }
}

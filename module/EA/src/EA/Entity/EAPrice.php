<?php
namespace EA\Entity;

use Base\Controller\BaseFunctions;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
* @ORM\Entity
* @ORM\HasLifecycleCallbacks
* @ORM\Table(name="ea_price")
*/

class EAPrice
{

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    protected $title;

    /**
     * @ORM\Column(name="link_checkout", type="string", length=255, nullable=true)
     */
    protected $link_checkout;

    /**
     * @ORM\Column(name="price", type="float", nullable=false)
     */
    protected $price;

    /**
     * @var \EA\Entity\EA
     *
     * @ORM\ManyToOne(targetEntity="EA\Entity\EA")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ea_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * })
     */
    private $ea;

    /**
     * @ORM\Column(name="free", type="boolean", nullable=true)
     */
    protected $free;

    /**
     * @ORM\Column(name="first", type="boolean", nullable=true)
     */
    protected $first;

    public function __construct($options = array())
    {
        (new Hydrator\ClassMethods)->hydrate($options, $this);
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = new \DateTime("now");
    }

    public function __toString()
    {
       return $this->getTitle();
    }

    public function functions(){
        return new BaseFunctions();
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

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
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return EA
     */
    public function getEa()
    {
        return $this->ea;
    }

    public function getEaStr()
    {
        return $this->ea->getName();
    }

    /**
     * @param EA $ea
     */
    public function setEa($ea)
    {
        $this->ea = $ea;
    }

    /**
     * @return mixed
     */
    public function getLinkCheckout()
    {
        return $this->link_checkout;
    }

    /**
     * @param mixed $link_checkout
     */
    public function setLinkCheckout($link_checkout)
    {
        $this->link_checkout = $link_checkout;
    }

    /**
     * @return mixed
     */
    public function getFree()
    {
        return $this->free;
    }

    public function getFreeStr()
    {
        return ($this->free)?'Sim':'Não';
    }

    /**
     * @param mixed $free
     */
    public function setFree($free)
    {
        $this->free = $free;
    }

    /**
     * @return mixed
     */
    public function getFirst()
    {
        return $this->first;
    }

    public function getFirstStr()
    {
        return ($this->first)?'Sim':'Não';
    }

    /**
     * @param mixed $first
     */
    public function setFirst($first)
    {
        $this->first = $first;
    }

}

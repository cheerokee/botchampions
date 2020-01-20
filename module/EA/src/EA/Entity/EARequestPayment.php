<?php
namespace EA\Entity;

use Base\Controller\BaseFunctions;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
* @ORM\Entity
* @ORM\HasLifecycleCallbacks
* @ORM\Table(name="ea_request_payment")
*/

class EARequestPayment
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
     * @var \EA\Entity\EAContract
     *
     * @ORM\ManyToOne(targetEntity="EA\Entity\EAContract")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ea_contract_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * })
     */
    private $ea_contract;

    /**
     * @var \EA\Entity\EAYield
     *
     * @ORM\ManyToOne(targetEntity="EA\Entity\EAYield")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ea_yield_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * })
     */
    private $ea_yield;

    /**
     * @ORM\Column(name="value", type="float", nullable=false)
     */
    protected $value;

    /**
     * @ORM\Column(name="paid_out", type="boolean", nullable=true)
     */
    protected $paid_out;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_payment", type="datetime", nullable=true)
     */
    private $date_payment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="due_date", type="datetime", nullable=false)
     */
    private $due_date;

    public function __construct($options = array())
    {
        (new Hydrator\ClassMethods)->hydrate($options, $this);
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = new \DateTime("now");
    }

    public function __toString()
    {
       return "Contrato: Nº " . $this->getEaContract()->getId() .
           " - Vencimento: " . $this->getDueDate()->format('d/m/Y') .
           " - Valor: " .  number_format($this->getValue(), 2, ',', '.') .
           " - Pago?: " . $this->getPaidOutStr();
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
     * @return EAContract
     */
    public function getEaContract()
    {
        return $this->ea_contract;
    }

    /**
     * @param EAContract $ea_contract
     */
    public function setEaContract($ea_contract)
    {
        $this->ea_contract = $ea_contract;
    }

    /**
     * @return EAYield
     */
    public function getEaYield()
    {
        return $this->ea_yield;
    }

    /**
     * @param EAYield $ea_yield
     */
    public function setEaYield($ea_yield)
    {
        $this->ea_yield = $ea_yield;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getPaidOut()
    {
        return $this->paid_out;
    }

    public function getPaidOutStr()
    {
        return ($this->paid_out) ? "Sim" : "Não";
    }

    /**
     * @param mixed $paid_out
     */
    public function setPaidOut($paid_out)
    {
        $this->paid_out = $paid_out;
    }

    /**
     * @return \DateTime
     */
    public function getDatePayment()
    {
        return $this->date_payment;
    }

    /**
     * @param \DateTime $date_payment
     */
    public function setDatePayment($date_payment)
    {
        $this->date_payment = $date_payment;
    }

    /**
     * @return \DateTime
     */
    public function getDueDate()
    {
        return $this->due_date;
    }

    /**
     * @param \DateTime $due_date
     */
    public function setDueDate($due_date)
    {
        $this->due_date = $due_date;
    }
}

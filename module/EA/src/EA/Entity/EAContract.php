<?php
namespace EA\Entity;

use Base\Controller\BaseFunctions;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
* @ORM\Entity
* @ORM\HasLifecycleCallbacks
* @ORM\Table(name="ea_contract")
* @ORM\Entity(repositoryClass="EA\Entity\EAContractRepository")
*/

class EAContract
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
     * @var \Admin\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Admin\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * })
     */
    private $user;

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
     * @var \EA\Entity\EAXMAccount
     *
     * @ORM\ManyToOne(targetEntity="EA\Entity\EAXMAccount",
     *      inversedBy="contracts", fetch="LAZY")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ea_xm_account_id", referencedColumnName="id",
     *      nullable=true,
     *      onDelete="SET NULL")
     * })
     */
    private $ea_xm_account;

    /**
     * @var \EA\Entity\EAPrice
     *
     * @ORM\ManyToOne(targetEntity="EA\Entity\EAPrice")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ea_price_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     * })
     */
    private $ea_price;

    /**
     * @ORM\Column(name="value_in_account", type="float", nullable=true)
     */
    protected $value_in_account;

    /**
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    protected $status;

    /**
     * @ORM\Column(name="receipt", type="string", length=255, nullable=true)
     */
    protected $receipt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_start", type="datetime", nullable=true)
     */
    private $date_start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_finish", type="datetime", nullable=true)
     */
    private $date_finish;

    /**
     * @ORM\Column(name="step", type="integer", nullable=true)
     */
    protected $step;

    /**
     * @ORM\Column(name="payment_method", type="integer", nullable=false)
     */
    protected $payment_method;

    /**
     * @ORM\Column(name="observation", type="text", length=65000, nullable=true)
     */
    protected $observation;


    public function __construct($options = array())
    {
        (new Hydrator\ClassMethods)->hydrate($options, $this);
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = new \DateTime("now");
    }

    public function __toString()
    {
       return 'Cod. '.$this->getId().' - '.$this->getEa().' - '.$this->getUser();
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

    public function getUpdatedAtStr()
    {
        return $this->updatedAt->format('d/m/Y');
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
     * @return \Admin\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \Admin\Entity\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
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
        return $this->ea;
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
    public function getStatus()
    {
        return $this->status;
    }

    public function getStatusStr()
    {
        $status = '';
        switch($this->status){
            case 0:
                $status = 'Pendente';
                break;
            case 1:
                $status = 'Ativo';
                break;
            case 2:
                $status = 'Cancelado';
                break;
        }

        return $status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getReceipt()
    {
        return $this->receipt;
    }

    /**
     * @param mixed $receipt
     */
    public function setReceipt($receipt)
    {
        $this->receipt = $receipt;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->date_start;
    }

    public function getDateStartStr()
    {
        if($this->date_start){
            return $this->date_start->format('d/m/Y');
        }else{
            return "Não Definido";
        }
    }

    /**
     * @param \DateTime $date_start
     */
    public function setDateStart($date_start)
    {
        $this->date_start = $date_start;
    }

    /**
     * @return \DateTime
     */
    public function getDateFinish()
    {
        return $this->date_finish;
    }

    public function getDateFinishStr()
    {
        if($this->date_finish){
            return $this->date_finish->format('d/m/Y');
        }else{
            return "Não Definido";
        }
    }

    /**
     * @param \DateTime $date_finish
     */
    public function setDateFinish($date_finish)
    {
        $this->date_finish = $date_finish;
    }

    /**
     * @return EAXMAccount
     */
    public function getEaXmAccount()
    {
        return $this->ea_xm_account;
    }

    /**
     * @param EAXMAccount $ea_xm_account
     */
    public function setEaXmAccount($ea_xm_account)
    {
        $this->ea_xm_account = $ea_xm_account;
    }

    /**
     * @return EAPrice
     */
    public function getEaPrice()
    {
        return $this->ea_price;
    }

    /**
     * @param EAPrice $ea_price
     */
    public function setEaPrice($ea_price)
    {
        $this->ea_price = $ea_price;
    }

    /**
     * @return mixed
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * @param mixed $step
     */
    public function setStep($step)
    {
        $this->step = $step;
    }

    /**
     * @return mixed
     */
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }

    /**
     * @param mixed $payment_method
     */
    public function setPaymentMethod($payment_method)
    {
        $this->payment_method = $payment_method;
    }

    /**
     * @return mixed
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * @param mixed $observation
     */
    public function setObservation($observation)
    {
        $this->observation = $observation;
    }

    /**
     * @return mixed
     */
    public function getValueInAccount()
    {
        return $this->value_in_account;
    }

    public function getValueInAccountStr()
    {
        return '$ ' . number_format($this->value_in_account, 2, ',', '.');
    }

    /**
     * @param mixed $value_in_account
     */
    public function setValueInAccount($value_in_account)
    {
        $this->value_in_account = $value_in_account;
    }
}

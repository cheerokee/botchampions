<?php
namespace Myfx\Entity;

use Base\Controller\BaseFunctions;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
* @ORM\Entity
* @ORM\HasLifecycleCallbacks
* @ORM\Table(name="graph_performance")
*/

class GraphPerformance
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
     * @ORM\Column(name="account", type="float", nullable=false)
     */
    protected $account;

    /**
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    protected $active;

    /**
     * @var \Myfx\Entity\ConfigurationMyfx
     *
     * @ORM\ManyToOne(targetEntity="Myfx\Entity\ConfigurationMyfx")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="configuration_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * })
     */
    private $configuration;

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
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param mixed $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    public function getActiveStr()
    {
        return ($this->active)?"Sim":"Não";
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return ConfigurationMyfx
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param ConfigurationMyfx $configuration
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
    }
}

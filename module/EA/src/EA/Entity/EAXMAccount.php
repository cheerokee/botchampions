<?php
namespace EA\Entity;

use Base\Controller\BaseFunctions;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
* @ORM\Entity
* @ORM\HasLifecycleCallbacks
* @ORM\Table(name="ea_xm_account")
* @ORM\Entity(repositoryClass="EA\Entity\EAXMAccountRepository")
*/

class EAXMAccount
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
     * @ORM\Column(name="number", type="string", length=255, nullable=false)
     */
    protected $number;

    /**
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    protected $password;

    /**
     * @ORM\Column(name="server", type="string", length=255, nullable=false)
     */
    protected $server;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="EA\Entity\EAContract",
     *      cascade={"persist", "remove","merge","refresh"},
     *      mappedBy="ea_xm_account", orphanRemoval=true)
     */
    private $contracts;

    public function __construct($options = array())
    {
        (new Hydrator\ClassMethods)->hydrate($options, $this);
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = new \DateTime("now");
    }

    public function __toString()
    {
       return $this->getNumber().' - ' . $this->getServer().' - '.$this->getUser();
    }

    public function getName()
    {
        return $this->getNumber().' - ' . $this->getServer().' - '.$this->getUser();
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
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    public function getNumberCollumn()
    {
        /**
         * @var EAContract[] $db_contracts;
         */
        $db_contracts = $this->getContracts();
        $contracts_table = '';

        if(!empty($db_contracts))
        {
            $contracts_table = '
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Serviço</th>
                    <th>Status</th>
                    <th>Data da Aquisição</th>
                    <th>Data da Expiração</th>
                </tr>
            </thead>
                <tbody>';

            foreach ($db_contracts as $db_contract){
                $contracts_table .= '
                <tr>
                    <td>' . $db_contract->getEa() . '</td>
                    <td>' . $db_contract->getStatusStr() . '</td>
                    <td>' . $db_contract->getDateStartStr() . '</td>
                    <td>' . $db_contract->getDateFinishStr() . '</td>
                </tr>
                ';
            }

            $contracts_table .= '
                </tbody>
            </table>';
        }
        return '
        <form class="form-inline">
          <div class="form-group">
            <div class="input-group">
              <input  type="text" 
                      class="form-control text-center" 
                      id="account_xm_' . $this->getId() . '" 
                      value="' . $this->getNumber() . '">
              <input  type="password" 
                      class="form-control text-center" 
                      id="password_xm_' . $this->getId() . '" 
                      value="' . $this->getPassword() . '">
              <input  type="text" 
                      class="form-control text-center" 
                      id="server_xm_' . $this->getId() . '" 
                      value="' . $this->getServer() . '">
              <div onclick="saveAccountXm(' . $this->getId() . ');" id="save_account_xm_' . $this->getId() . '"  class="input-group-addon save_account_xm_btn"><i class="fa fa-save"></i></div>
            </div>
          </div>          
        </form>
        ' . $contracts_table;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param mixed $server
     */
    public function setServer($server)
    {
        $this->server = $server;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContracts()
    {
        return $this->contracts;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $contracts
     */
    public function setContracts($contracts)
    {
        $this->contracts = $contracts;
    }
}

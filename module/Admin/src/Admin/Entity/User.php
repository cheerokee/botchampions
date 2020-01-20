<?php
namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

use Zend\Math\Rand,
    Zend\Crypt\Key\Derivation\Pbkdf2;
use Zend\Stdlib\Hydrator;

use Admin\Entity\Perfil;
use Doctrine\Common\Collections\Criteria;


/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Admin\Entity\UserRepository")
 */
class User
{ 
    protected $em;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=false)
     */
    private $salt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="active_key", type="string", length=255, nullable=false)
     */
    private $activeKey;

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
     * @var string
     *
     * @ORM\Column(name="indicado_por", type="string", length=255, nullable=true)
     */
    private $indicadoPor;

    /**
     * @var string
     *
     * @ORM\Column(name="indicado_por_fifa", type="string", length=255, nullable=true)
     */
    private $indicadoPorFifa;
    
    /**
     * @var string
     *
     * @ORM\Column(name="telefone", type="string", length=255, nullable=true)
     */
    private $telefone;
    
    /**
     * @var string
     *
     * @ORM\Column(name="whatsapp", type="string", length=255, nullable=true)
     */
    private $whatsapp;
    
    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=255, nullable=true)
     */
    private $facebook;
    
    /**
     * @var string
     *
     * @ORM\Column(name="cep", type="string", length=255, nullable=true)
     */
    private $cep;
    
    /**
     * @var string
     *
     * @ORM\Column(name="endereco", type="string", length=255, nullable=true)
     */
    private $endereco;
    
    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=255, nullable=true)
     */
    private $numero;
    
    /**
     * @var string
     *
     * @ORM\Column(name="complemento", type="string", length=255, nullable=true)
     */
    private $complemento;
    
    /**
     * @var string
     *
     * @ORM\Column(name="bairro", type="string", length=255, nullable=true)
     */
    private $bairro;
    
     /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;
    
     /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=255, nullable=true)
     */
    private $state;
    
    /**
     * @var string
     *
     * @ORM\Column(name="imagem", type="string", length=255, nullable=true)
     */
    private $imagem;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_admin", type="boolean", nullable=true)
     */
    private $isAdmin;

    /**
     * @var string
     *
     * @ORM\Column(name="documento", type="string", length=255, nullable=true)
     */
    private $documento;

    /**
     * @var \Date
     *
     * @ORM\Column(name="data_ativacao", type="datetime", nullable=true)
     */
    private $data_ativacao;

    /**
     * @var string
     *
     * @ORM\Column(name="rg", type="string", length=255, nullable=true)
     */
    private $rg;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="Admin\Entity\UserPerfil",
     *      cascade={"persist", "remove","merge","refresh"},
     *      mappedBy="user", orphanRemoval=true)
     */
    private $user_perfis;

    public function __construct(array $options = array()){

        (new Hydrator\ClassMethods())->hydrate($options, $this);

        $this->createdAt = new \DateTime("now");
        $this->updatedAt = new \DateTime("now");

        $this->salt = base64_encode(Rand::getBytes(8,true));
        $this->activeKey = md5($this->email.$this->salt);

    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
    /**
     * @return the $rg
     */
    public function getRg()
    {
        return $this->rg;
    }

    /**
     * @param string $rg
     */
    public function setRg($rg)
    {
        $this->rg = $rg;
    }

    /**
     * @return the $documento
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * @return the $data_ativacao
     */
    public function getData_ativacao()
    {
        return $this->data_ativacao;
    }

    /**
     * @param Date $data_ativacao
     */
    public function setData_ativacao($data_ativacao)
    {
        $this->data_ativacao = $data_ativacao;
    }

    /**
     * @param string $documento
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;
    }

    /**
     * @return the $isAdmin
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    public function isIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param boolean $isAdmin
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }

    /**
     * @return the $imagem
     */
    public function getImagem()
    {
        return $this->imagem;
    }

    /**
     * @param string $imagem
     */
    public function setImagem($imagem)
    {
        $this->imagem = $imagem;
    }

    /**
     * @return the $indicadoPor
     */
    public function getIndicadoPor()
    {
        return $this->indicadoPor;
    }

    /**
     * @return the $telefone
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @return the $whatsapp
     */
    public function getWhatsapp()
    {
        return $this->whatsapp;
    }

    /**
     * @return the $facebook
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @return the $cep
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * @return the $endereco
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * @return the $numero
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @return the $complemento
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * @return the $bairro
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * @return the $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return the $state
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @param string $indicadoPor
     */
    public function setIndicadoPor($indicadoPor)
    {
        $this->indicadoPor = $indicadoPor;
    }

    /**
     * @param string $telefone
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    /**
     * @param string $whatsapp
     */
    public function setWhatsapp($whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    /**
     * @param string $facebook
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * @param string $cep
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    /**
     * @param string $endereco
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    /**
     * @param string $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @param string $complemento
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
    }

    /**
     * @param string $bairro
     */
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * @return the $nome
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return the $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return the $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return the $salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @return the $active
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return the $activeKey
     */
    public function getActiveKey()
    {
        return $this->activeKey;
    }

    /**
     * @return the $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return the $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $this->encryptPassword($password);
        return $this;
    }
    
    public function encryptPassword($password){
        #return base64_encode(Pbkdf2::calc('sha256', $password, $this->salt, 10000,strlen($password*2)));
        return md5(sha1($password));
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }

    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @param string $activeKey
     */
    public function setActiveKey($activeKey)
    {
        $this->activeKey = $activeKey;
        return $this;
    }

    /**
     * @param DateTime $updatedAt
     * @ORM\PrePersist
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = new \DateTime('now');       
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = new \DateTime('now');
    }
    
    public function hasPermission($recurso,$item,$acao,$perfis){
        /**
         * @var Perfil $perfil
         * @var User $user
         */
       
        $p = $perfis;
        if(isset($p))
        foreach($p as $perfil){            
            if(!is_object($perfil)){
                $inf = $perfil;
            }else{
                $inf = $perfil->getInformation();
            }
                
            $information = json_decode($inf,true)['recursos'];
            if($information[$recurso][$item][$acao])
                return true;
        }     
        
        if($this->getIsAdmin())
            return true;
        
        return false;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserPerfis()
    {
        return $this->user_perfis;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $user_perfis
     */
    public function setUserPerfis($user_perfis)
    {
        $this->user_perfis = $user_perfis;
    }

    public function __toString()
    {
        return $this->getNome();
    }
}


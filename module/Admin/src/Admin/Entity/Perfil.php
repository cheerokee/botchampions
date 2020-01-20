<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Perfil
 *
 * @ORM\Table(name="perfil")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Admin\Entity\PerfilRepository")
 */
class Perfil
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=225, nullable=true)
     */
    public $nome;

//     /**
//      * @var \Doctrine\Common\Collections\Collection
//      *
//      * @ORM\ManyToMany(targetEntity="Entity\Entity\User", mappedBy="perfil")
//      */
//     private $user;
    
    /**
     * @var string
     *
     * @ORM\Column(name="information", type="text", length=65535, nullable=true)
     */
    public $information;
    
    /**
     * @return the $information
     */
    public function getInformation()
    {
        return $this->information;
    }

    /**
     * @param string $information
     */
    public function setInformation($information)
    {
        $this->information = $information;
    }

    /**
     * @return the $nome
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return the $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $user
     */
    public function setUser($user)
    {
        $this->user = $user;
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

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
  
}


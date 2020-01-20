<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table(name="city", indexes={@ORM\Index(name="fk_City_state", columns={"state"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Admin\Entity\CityRepository")
 */
class City
{
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
     * @ORM\Column(name="name", type="string", length=120, nullable=true)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=45, nullable=true)
     */
    private $code;


    /**
     * @var \Admin\Entity\State
     *
     * @ORM\ManyToOne(targetEntity="Admin\Entity\State")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="state", referencedColumnName="id", nullable=false)
     * })
     */
    private $state;
    
    /**
     * @return the $code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    public function __toString()
    {
        return $this->name." / ".$this->state->getUf();
    }
    
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

 /**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

 /**
     * @return the $state
     */
    public function getState()
    {
        return $this->state;
    }

 /**
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

 /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

 /**
     * @param \Customer\Entity\State $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }


  
}


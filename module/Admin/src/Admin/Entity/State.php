<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * State
 *
 * @ORM\Table(name="state", indexes={@ORM\Index(name="fk_State_country", columns={"country"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Admin\Entity\StateRepository")
 */
class State
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
     * @ORM\Column(name="name", type="string", length=75, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="uf", type="string", length=5, nullable=true)
     */
    private $uf;

    /**
     * @var \Admin\Entity\Country
     *
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Country")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country", referencedColumnName="id", nullable=false)
     * })
     */
    private $country;
    
    public function __toString()
    {
        return $this->name;
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
     * @return the $uf
     */
    public function getUf()
    {
        return $this->uf;
    }

 /**
     * @return the $country
     */
    public function getCountry()
    {
        return $this->country;
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
     * @param string $uf
     */
    public function setUf($uf)
    {
        $this->uf = $uf;
    }

 /**
     * @param \Admin\Entity\Country $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }


   
}


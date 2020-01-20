<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserPerfil
 *
 * @ORM\Table(name="user_perfil", indexes={@ORM\Index(name="fk_perfil", columns={"perfil_id"}),@ORM\Index(name="fk_user", columns={"user_id"})})
 * @ORM\Entity
 */
class UserPerfil
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
     * @var \Admin\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Admin\Entity\User",
     *      inversedBy="user_perfis", fetch="LAZY")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id",
     *      nullable=false,
     *      onDelete="CASCADE")
     * })
     */
    private $user;
    
    /**
     * @var \Admin\Entity\Perfil
     *
     * @ORM\ManyToOne(targetEntity="Admin\Entity\Perfil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="perfil_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $perfil;
    
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return the $perfil
     */
    public function getPerfil()
    {
        return $this->perfil;
    }

    /**
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param \Admin\Entity\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @param \Admin\Entity\Perfil $perfil
     */
    public function setPerfil($perfil)
    {
        $this->perfil = $perfil;
    }
}


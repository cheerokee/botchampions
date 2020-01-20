<?php
namespace Admin\Auth;

use Zend\Authentication\Adapter\AdapterInterface,
    Zend\Authentication\Result;

use Doctrine\ORM\EntityManager;

class Adapter implements AdapterInterface
{
    protected $em;
    protected $username;
    protected $password;

    public function __construct(EntityManager $em){
        $this->em = $em;
    }

    /**
     * @return the $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return the $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param field_type $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param field_type $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }



    /**
     * {@inheritDoc}
     * @see \Zend\Authentication\Adapter\AdapterInterface::authenticate()
     */
    public function authenticate()
    {
        $repository = $this->em->getRepository('Admin\Entity\User');

        $user = $repository->findByEmailAndPassword($this->getUsername(),$this->getPassword());

        if($user){
            return new Result(Result::SUCCESS,array('user'=>$user),array('Ok'));

        }else
            return new Result(Result::FAILURE_CREDENTIAL_INVALID,null,array());


    }

}

<?php
namespace Admin\Service;
//PULO DO GATO
use Doctrine\ORM\EntityManager;


abstract class Auth{
    /*
     * @var EntityManager
     */
    protected $em;
    //NOME DA ENTIDADE QUE VAMOS PRECISAR
    protected $entity;
    
    public function __construct(EntityManager $em){
        $this->em = $em;
    }
    
}
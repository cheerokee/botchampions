<?php
namespace Admin\Service;

use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator;

class Perfil extends AbstractService
{    
    public $em;
   
    public function __construct(EntityManager $em){
        parent::__construct($em);
        $this->em = $em;
        $this->entity = 'Admin\Entity\Perfil';

    }
    
    /**
     * @return the $em
     */
    public function getEm()
    {
        return $this->em;
    }

    public function insert(array $data){   
        /**
         * 
         * @var Perfil $entity
         */
        $entity = parent::insert($data);        
        $entity->setNome($data['nome']);
        
        $this->em->persist($entity);
        $this->em->flush();
        
        if(isset($entity)){
            return true;
        }else
            return false;
    }
        
    public function update(array $data){  
       
        $entity = $this->em->getReference($this->entity,$data['id']);
          
        (new Hydrator\ClassMethods())->hydrate($data,$entity);
        $this->em->persist($entity);
        $this->em->flush();
        
        if(isset($entity)){
            return true;
        }else
            return false;
    }
}

?>
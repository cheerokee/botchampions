<?php
namespace Admin\Entity;

use Doctrine\ORM\EntityRepository;

class StateRepository extends EntityRepository
{
    public function getStateByString($string){       
       
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(array(
            'x'
        ))
        ->from('Admin\Entity\State', 'x')
        ->where(
            $qb->expr()->like("x.uf","'".trim($string)."%'"))            
        ->orWhere(
            $qb->expr()->like("x.name","'".trim($string)."%'"));        
        
        if(!empty($qb->getQuery()->getResult())){
            return $qb->getQuery()->getResult()[0];
        }else{
            return null;
        }
    }
    
}
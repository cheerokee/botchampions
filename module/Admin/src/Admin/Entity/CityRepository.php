<?php
namespace Admin\Entity;

use Doctrine\ORM\EntityRepository;

class CityRepository extends EntityRepository
{
    public function getCityByName($name){
        
     $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(array(
            'x'
        ))
        ->from('Admin\Entity\City', 'x')
        ->where(
            $qb->expr()->like("x.name","'".trim($name)."%'"));          
        
        if(!empty($qb->getQuery()->getResult())){
            return $qb->getQuery()->getResult()[0];
        }else{
            return null;
        }
    }
    
}
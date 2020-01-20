<?php
namespace Admin\Entity;
use Doctrine\ORM\EntityRepository;
class UserRepository extends EntityRepository
{
    //Metodo customizado
    public function findByEmailAndPassword($email, $password){
        //Buscando usuario pelo email
        $user = $this->findOneBy(array('email'=>$email,'active'=>1));
        
        if($user){
            $hashSenha = $user->encryptPassword($password);
            
           
            if($hashSenha == $user->getPassword()){            
                return $user;
            }else{
                return false;
            }      
        }else{            
            return false;
        }
    }
    
    public function findFilter($fields){
     
        foreach($fields as $type=>$v){          
            
            foreach($v as $nome_campo => $valor){                
                
                if($type == "like"){                                        
                    $tmp[] = " u.".$nome_campo." LIKE '%".$valor."%' ";
                }
                if($type == "exactly"){
                    $tmp[] = " u.".$nome_campo." = ".$valor." ";
                }
               
            }
        }
        
        $where = trim(implode('AND',$tmp));      
       
        
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(array(
            'u'
        ))
        ->from('Admin\Entity\User', 'u')
        ->where($where);
           
        if(!empty($qb->getQuery()->getResult())){
            return $qb->getQuery()->getResult();
        }else{
            return null;
        }
    }
    
    public function findAllWithWhere($where = null){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(array(
            'u'
        ))
        ->from('Admin\Entity\User', 'u')
        ->where('1=1 '.$where)
        ->orderBy("u.id","DESC");
        
        if(!empty($qb->getQuery()->getResult())){
            return $qb->getQuery()->getResult();
        }else{
            return null;
        }
        
    }
    
    public function findAllWithWhereAndId($where,$id){

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(array(
            'u'
        ))
        ->from('Admin\Entity\User', 'u')
        ->where('u.id='.$id.' AND '.$where);

        if(!empty($qb->getQuery()->getResult())){
            return $qb->getQuery()->getResult();
        }else{
            return null;
        }

    }

    /**
     * @param array $fields
     * @return array|null
     */
    public function findByFilter($fields){
        $where = '';
        if(!empty($fields)){
            foreach($fields as $column => $value){
                if($column == 'nome'){
                    $where .= " AND u.nome LIKE '%".$value."%'";
                }
            }
        }
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(array(
            'u'
        ))
            ->from('Admin\Entity\User', 'u')
            ->where('1=1'.$where);

        if(!empty($qb->getQuery()->getResult())){
            return $qb->getQuery()->getResult();
        }else{
            return null;
        }

    }
    
}

function codificacao($string) { return mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1'); }

<?php
namespace EA\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
class EAContractRepository extends EntityRepository
{

    public function findByOrderId(){
        $alias = 'x';
        $tabela = 'EA\Entity\EAContract';

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(array(
            $alias
        ))
            ->from($tabela,$alias)
            ->orderBy('x.id','DESC');

        if(!empty($qb->getQuery()->getResult())){
            return $qb->getQuery()->getResult();
        }else{
            return null;
        }
    }

    public function findByOrderDate(){
        $alias = 'x';
        $tabela = 'EA\Entity\EAContract';

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(array(
            $alias
        ))
            ->from($tabela,$alias)
            ->orderBy('x.date_start','DESC');

        if(!empty($qb->getQuery()->getResult())){
            return $qb->getQuery()->getResult();
        }else{
            return null;
        }
    }

    public function findByRangeDate($date_start,$date_finish){
        $alias = 'x';
        $tabela = 'EA\Entity\EAContract';

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(array(
            $alias
        ))
        ->from($tabela,$alias)
        ->where("(x.date_start >= DATE('".$date_start."') AND x.date_start <= DATE('".$date_finish."')) OR (x.date_finish >= DATE('".$date_start."') AND x.date_finish <= DATE('".$date_finish."'))");

        if(!empty($qb->getQuery()->getResult())){
            return $qb->getQuery()->getResult();
        }else{
            return null;
        }
    }

    public function findByFilter($data){

        $alias = 'x';
        $tabela = 'EA\Entity\EAContract';

        $where = "1=1";

        if(isset($data['ea-contract_user_id']) && $data['ea-contract_user_id'] != ''){
            $where .= " AND x.user = " . $data['ea-contract_user_id'];
        }

        if(isset($data['ea-contract_ea_id']) && $data['ea-contract_ea_id'] != ''){
            $where .= " AND x.ea = " . $data['ea-contract_ea_id'];
        }

        if(isset($data['ea-contract_ea-xm-account_id']) && $data['ea-contract_ea-xm-account_id'] != ''){
            $where .= " AND x.ea_xm_account = " . $data['ea-contract_ea-xm-account_id'];
        }

        if(isset($data['ea-contract_status']) && $data['ea-contract_status'] != -1 && $data['ea-contract_status'] !== ''){
            $where .= " AND x.status = " . $data['ea-contract_status'];
        }

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(array(
            $alias
        ))
            ->from($tabela,$alias)
            ->where($where)
            ->orderBy('x.status','ASC')
            ->addOrderBy('x.date_finish','ASC');

        if(!empty($qb->getQuery()->getResult())){
            return $qb->getQuery()->getResult();
        }else{
            return array();
        }
    }

    public function getBlackListEspelhamento(){

        $alias = 'ec';
        $tabela = 'EA\Entity\EAContract';

        $alias_ij1 = 'e';
        $tabela_ij1 = 'EA\Entity\EA';

        $where = "DATE(ec.date_finish) <= DATE('" . date('Y-m-d') . "')";

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(array(
            $alias
        ))
            ->from($tabela,$alias)
            ->innerJoin($tabela_ij1,$alias_ij1,JOIN::WITH, $qb->expr()->andx(
                $qb->expr()->eq('e.id', 'ec.ea')
            ))
            ->where($where)
            ->orderBy('ec.status','ASC')
            ->addOrderBy('ec.date_finish','DESC');

        if(!empty($qb->getQuery()->getResult())){
            return $qb->getQuery()->getResult();
        }else{
            return array();
        }
    }
}


<?php
namespace EA\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
class EAXMAccountRepository extends EntityRepository
{
    public function findByFilter($data){

        $alias = 'exa';
        $tabela = 'EA\Entity\EAXMAccount';

        $alias_ij1 = 'ec';
        $tabela_ij1 = 'EA\Entity\EAContract';

        $where = "1=1";

        if(isset($data['ea-xm-account_user_id']) && $data['ea-xm-account_user_id'] != ''){
            $where .= " AND exa.user = " . $data['ea-xm-account_user_id'];
        }

        if(isset($data['ea-xm-account_ea_id']) && $data['ea-xm-account_ea_id'] != ''){
            $where .= " AND ec.ea = " . $data['ea-xm-account_ea_id'];
        }

        if(isset($data['ea-xm-account_ea-xm-account_id']) && $data['ea-xm-account_ea-xm-account_id'] != ''){
            $where .= " AND exa.id = " . $data['ea-xm-account_ea-xm-account_id'];
        }

//        if(isset($data['ea-xm-account_status']) && $data['ea-xm-account_status'] != -1 && $data['ea-xm-account_status'] !== ''){
//            $where .= " AND ec.status = " . $data['ea-xm-account_status'];
//        }

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(array($alias))
            ->from($tabela,$alias)
            ->leftJoin($tabela_ij1,$alias_ij1,JOIN::WITH, $qb->expr()->andx(
                $qb->expr()->eq('ec.ea_xm_account', 'exa.id')
            ))
            ->where($where);

        if(!empty($qb->getQuery()->getResult())){
            return $qb->getQuery()->getResult();
        }else{
            return array();
        }
    }
}


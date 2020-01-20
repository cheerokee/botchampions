<?php
namespace EA\Service;

use Base\Service\AbstractService;

class EAXMAccount extends AbstractService{
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'EA\Entity\EAXMAccount';
    }

}


























?>
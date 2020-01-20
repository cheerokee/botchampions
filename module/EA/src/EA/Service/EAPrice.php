<?php
namespace EA\Service;

use Base\Service\AbstractService;

class EAPrice extends AbstractService{
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'EA\Entity\EAPrice';
    }

}


























?>

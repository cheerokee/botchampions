<?php
namespace Myfx\Service;

use Base\Service\AbstractService;

class GraphPerformance extends AbstractService{
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Myfx\Entity\GraphPerformance';
    }
}


























?>

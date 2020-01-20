<?php
namespace Myfx\Service;

use Base\Service\AbstractService;

class ConfigurationMyfx extends AbstractService{
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Myfx\Entity\ConfigurationMyfx';
    }
}


























?>

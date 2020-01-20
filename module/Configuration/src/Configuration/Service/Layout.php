<?php
namespace Configuration\Service;

use Base\Service\AbstractService;

class Layout extends AbstractService{
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Configuration\Entity\Layout';
    }

    public function insert(array $data)
    {
        $entity = parent::insert($data);
    }

    public function update(array $data)
    {
        $entity = parent::update($data);
    }
}


























?>
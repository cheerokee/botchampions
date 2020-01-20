<?php
namespace EA\Service;

use Base\Mail\Mail;
use Base\Service\AbstractService;
use Zend\Mail\Transport\Smtp as SmtpTransport;

class EAYield extends AbstractService{

    protected $em;

    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'EA\Entity\EAYield';
    }
}


























?>

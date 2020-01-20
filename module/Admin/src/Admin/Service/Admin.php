<?php
namespace Admin\Service;
use Doctrine\ORM\EntityManager;
use Zend\Mail\Transport\Smtp as SmtpTransport;

class Admin{
    protected $transport;
    protected $view;
    
    public function __construct(EntityManager $em, SmtpTransport $tranport, $view){
        parent::__construct($em);
          
        $this->view = $view;
    }
    
  
}




























?>
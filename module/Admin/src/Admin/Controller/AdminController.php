<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractActionController
{
    protected $em;
    
    public function __construct(){      
       
        $this->controller = 'admin';
        $this->route = 'admin';
    
    }
    
    //Register action foi criado com esse nome, por que la no module.config.php , foi definido que action recebe register.
    public function indexAction()
    {
        $this->layout()->setTemplate('layout/layout.phtml');
        
        return new ViewModel(array());
        
    }
    
    public function defaultAtion(){
        
        $this->layout()->setTemplate('layout/layout.phtml');
        
        return new ViewModel(array());
        
    }
    
    /**
     *
     * @return EntityManager
     */
    protected function getEm(){
        if(null === $this->em){
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    
            return $this->em;
        }
    }
  
}

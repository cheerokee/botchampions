<?php
namespace Configuration\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public $em;

    public function indexAction(){
        $user = $this->getLogin();
        return new ViewModel(array('em'=>$this->getEm(),'user'=>$user));
    }

    public function getLogin()
    {
        $session = (array)$_SESSION['Admin'];

        foreach ($session as $v) {
            if (isset($v['storage']))
                $login = $v['storage'];
        }

        return $login;
    }

    public function getEm(){
        if(null === $this->em){
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    
            return $this->em;
        }
    }
    
}

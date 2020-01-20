<?php
namespace Admin\View\Helper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\View\Helper\AbstractHelper,
    Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;

class UserPermission extends AbstractHelper implements ServiceLocatorAwareInterface{
    protected $serviceLocator,$em;

    protected $authService;

    public function getAuthService() {

        return $this->authService;
    }

    public function permite($recurso,$item,$privilege) {
        return $this->__invoke($recurso,$item,$privilege);
    }

    public function __invoke($recurso,$item,$privilege) {

        $helperPluginManager = $this->getServiceLocator();
        $serviceManager = $helperPluginManager->getServiceLocator();
        $this->setEm($serviceManager->get('Doctrine\ORM\EntityManager'));

        $sessionStorage = new SessionStorage('Admin');
        $this->authService = new AuthenticationService;
        $this->authService->setStorage($sessionStorage);

        if ($this->getAuthService()->hasIdentity()) {
            $user =  $this->getAuthService()->getIdentity();
            $userPerfis = $this->getEm()->getRepository('Admin\Entity\UserPerfil')->findBy(array('user'=>$user));

            $permitido = false;
            if(!empty($userPerfis)){
                foreach($userPerfis as $userPerfil){

                    if($permitido == true)
                        break;
                    $information = json_decode($userPerfil->getPerfil()->getInformation(),true);
                    $permitido = ($information['recursos'][$recurso][$item][$privilege] == '1' || $userPerfil->getUser()->getIsAdmin())?true:false;
                }
            }

            return $permitido;
        }else {
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @param mixed $em
     */
    public function setEm($em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritDoc}
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     */
    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * {@inheritDoc}
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}

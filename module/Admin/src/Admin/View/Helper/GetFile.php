<?php

namespace Admin\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class GetFile extends AbstractHelper implements ServiceLocatorAwareInterface{
    protected $serviceLocator,$em;

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

    public function __invoke($controller,$campo,$id_entity = null) {
        if($id_entity == null){
            return false;
        }
        $helperPluginManager = $this->getServiceLocator();
        // the second one gives access to... other things.
        $serviceManager = $helperPluginManager->getServiceLocator();
        $this->setEm($serviceManager->get('Doctrine\ORM\EntityManager'));

        switch($controller){
            case 'ea-contract':
                $file = $this->getEm()->getRepository('EA\Entity\EAContract')->findOneById($id_entity)->getReceipt();
                $file = "arquivos/ea/comprovantes/".$file;
                break;
            case 'users':
                $file = $this->getEm()->getRepository('Admin\Entity\User')->findOneById($id_entity)->getImagem();
                $file = 'img/clientes/'.$file;
                break;
        }

        if (file_exists($file)) {
            return str_replace('public','',$file);
        }

        if (file_exists('public/' . $file) || file_exists($file)) {
            return '/' . $file;
        } else {
            return false;
        }
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

?>

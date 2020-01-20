<?php
namespace Admin;

use Zend\Mvc\MvcEvent;

use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

use Admin\Auth\Adapter as AuthAdapter;

use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;

use Zend\ModuleManager\ModuleManager;

class Module
{
	private $em;

    public function getConfig(){
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getAutoloaderConfig(){
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
        
    public function init(ModuleManager $moduleManager){
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        #Criando mais um evento
        $sharedEvents->attach('Zend\Mvc\Controller\AbstractActionController',
                                MvcEvent::EVENT_DISPATCH,
                                array($this,'validaAuth')
                                ,100);
    }
   
    public function validaAuth($e){
        $auth = new AuthenticationService;
        $auth->setStorage(new SessionStorage("Admin"));
    
        $controller = $e->getTarget();
        #Pega a rota que esta sendo acessada
        $matchedRoute = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();
       
        if(!$auth->hasIdentity() && ($matchedRoute == "admin" || $matchedRoute == "admin/paginator" || $matchedRoute == "home" || $matchedRoute == "admin-module" || $matchedRoute == "admin-module/paginator"))
            return $controller->redirect()->toRoute('sonuser-auth');
    }
    
    
    public function getServiceConfig()
    {
        return array(
        	'factories' => array(
				'Admin\Service\UserConta' => function ($sm){
					return new Service\UserConta($sm->get('Doctrine\ORM\EntityManager'));
				},
				'Admin\Form\UserConta' => function ($sm){
					return new Form\UserConta($sm->get('Doctrine\ORM\EntityManager'));
				},
        	    'Admin\Service\Admin' => function ($sm)
        	    {
        	        return new Service\Admin($sm->get('Doctrine\ORM\EntityManager'));
        	    },
        	    'Admin\Service\Auth' => function ($sm)
        	    {
        	        return new Service\Admin($sm->get('Doctrine\ORM\EntityManager'));
        	    },
        	    'Admin\Service\Perfil' => function ($sm)
        	    {
        	        return new Service\Perfil($sm->get('Doctrine\ORM\EntityManager'));
        	    },
        	    'Admin\Mail\Transport' => function($sm){
            	    $config = $sm->get('Config');
            	   
            	    $transport = new SmtpTransport;
            	    $options = new SmtpOptions($config['mail']);
					$options->setPort($config['mail']['connection_config']['port']);
					$options->setHost($config['mail']['host']);


            	    $transport->setOptions($options);
            	    return $transport;
        	    },
        	    'Admin\Service\User' => function($sm){
        	        $userService = new Service\User($sm->get('Doctrine\ORM\EntityManager'),
                    	        $sm->get('Admin\Mail\Transport'),
                    	        $sm->get('View'));

        	        $userService->setConfigurationMail($sm->get('Config'));

            	    return $userService;
        	    },
        	    'Admin\Auth\Adapter' => function($sm){
            	    return new AuthAdapter($sm->get('Doctrine\ORM\EntityManager'));
        	    }
        	)
        );
    }
    
    public function getViewHelperConfig()
    {
		return array(
			'invokables' => array(
				'userIdentity'    => __NAMESPACE__ . '\View\Helper\UserIdentity',
				'simuladorComposto'    => __NAMESPACE__ . '\View\Helper\SimuladorComposto',
				'getInfos'    => __NAMESPACE__ . '\View\Helper\GetInfos',
				'getPayPerson'    => __NAMESPACE__ . '\View\Helper\GetPayPerson',
                'calculadora'    => __NAMESPACE__ . '\View\Helper\Calculadora'
			),
			'factories' => array(
				'userPermission' => function() {
					$helper = new View\Helper\UserPermission();
					return $helper;
				},
				'getMenu' => function() {
					$helper = new View\Helper\GetMenu;
					return $helper;
				},
				'getFile' => function() {
					$helper = new View\Helper\GetFile;
					return $helper;
				},
			)
		);

	}

	public function setEm($em){
		$this->em = $em;
	}

	public function getEm(){
		return $this->em;
	}
}

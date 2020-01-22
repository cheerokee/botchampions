<?php

namespace Admin\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Doctrine\ORM\EntityManager;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

class GetMenu extends AbstractHelper implements ServiceLocatorAwareInterface{
    protected $serviceLocator,$em;

    protected $authService;

    public function getAuthService() {

        return $this->authService;
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

    public function __invoke($user) {
        $helperPluginManager = $this->getServiceLocator();
        // the second one gives access to... other things.
        $serviceManager = $helperPluginManager->getServiceLocator();
        $this->setEm($serviceManager->get('Doctrine\ORM\EntityManager'));

        $expiracoes = array();
        $courses = array();

        return array(
            'dashboard'     =>  array(
                'subroutes'     =>  array('/'),
                'title'     =>  'Dashboard',
                'icon'      =>  'fa-dashboard txt-color-blue',
                'route'     =>  '/'
            ),
            'register'     =>  array(
                'subroutes' =>  array('/admin/users/edit/' . $user->getId()),
                'title'     =>  'Meu Cadastro',
                'icon'      =>  'fa-user txt-color-yellow',
                'route'     =>  '/admin/users/edit/' . $user->getId()
            ),

            'registers'     =>  array(
                'subroutes'     =>  array('/admin/users','/admin/perfil','/admin/curso','/admin/video'),
                'title'     =>  'Cadastros',
                'icon'      =>  'fa-list',
                'dropdown'  =>  array(
                    'user'  =>  array(
                        'action'    =>  'list',
                        'resource'  =>  'modulos',
                        'title'     =>  'Clientes',
                        'route'     =>  '/admin/users',
                        'icon'      =>  '',
                    ),
                    'perfil'  =>  array(
                        'action'    =>  'list',
                        'resource'  =>  'modulos',
                        'title'     =>  'Perfis',
                        'route'     =>  '/admin/perfil',
                        'icon'      =>  '',
                    ),

                    'layout'  =>  array(
                        'action'    =>  'list',
                        'resource'  =>  'modulos',
                        'title'     =>  'Configurações de Layout',
                        'route'     =>  '/admin-module/layout',
                        'icon'      =>  '',
                    ),
                    'layout-option'  =>  array(
                        'action'    =>  'list',
                        'resource'  =>  'modulos',
                        'title'     =>  'Opções de Layout',
                        'route'     =>  '/admin-module/layout-option',
                        'icon'      =>  '',
                    ),
                ),
            ),
            'automatic-investiment'     =>  array(
                'title'     =>  'Ativar meu Robô',
                'icon'      =>  'fa-android',
                'dropdown'  =>  array(
                    'ea-panel'  =>  array(
                        'title' => 'Painel de Serviços',
                        'route'     =>  '/admin-module/panel-ea/' . $user->getId(),
                        'authorize' => true
                    ),
                    'request-payment'  =>  array(
                        'title' => 'Solicitação de Pagamento',
                        'route'     =>  '/admin-module/request-payment',
                        'authorize' => false
                    ),
                    'cadastro-fpg'  =>  array(
                        'title'     => 'Cadastros',
                        'icon'      => '',
                        'authorize' => true,
                        'dropdown'  =>  array(
                            'blacklist-espelhamento'  =>  array(
                                'action'    =>  'list',
                                'resource'  =>  'modulos',
                                'title'     =>  'Contratos Expirados',
                                'route'     =>  '/admin-module/blacklist-espelhamento',
                                'icon'      =>  '',
                                'authorize' => false,
                            ),
                            'ea-contract'  =>  array(
                                'action'    =>  'list',
                                'resource'  =>  'modulos',
                                'title'     =>  'Contratos',
                                'route'     =>  '/admin-module/ea-contract',
                                'icon'      =>  '',
                                'authorize' => false,
                            ),
                            'ea-request-payment'  =>  array(
                                'action'    =>  'list',
                                'resource'  =>  'modulos',
                                'title'     =>  'Faturas',
                                'route'     =>  '/admin-module/ea-request-payment',
                                'icon'      =>  '',
                                'authorize' => false,
                            ),
                            'ea'  =>  array(
                                'action'    =>  'list',
                                'resource'  =>  'modulos',
                                'title'     =>  'Serviços Automáticos',
                                'route'     =>  '/admin-module/ea',
                                'icon'      =>  '',
                                'authorize' => false,
                            ),
                            'ea-xm-account'  =>  array(
                                'action'    =>  'list',
                                'resource'  =>  'modulos',
                                'title'     =>  'Contas Activtrades',
                                'route'     =>  '/admin-module/ea-xm-account',
                                'icon'      =>  '',
                                'authorize' => false,
                            ),
                            'ea-configuration'  =>  array(
                                'action'    =>  'list',
                                'resource'  =>  'modulos',
                                'title'     =>  'Configuração',
                                'route'     =>  '/admin-module/ea-configuration',
                                'icon'      =>  '',
                                'authorize' => false,
                            )
                        )
                    )
                )
            ),
//            'myfx' => array(
//                'title'     =>  'Myfx Informações',
//                'icon'      =>  'fa-bar-chart-o',
//                'label' => '',
//                'dropdown'  =>  array(
//                    'graph-performance'  =>  array(
//                        'title' => 'Gráfico de Desempenho',
//                        'route' => '/admin-module/graph-performance',
//                        'authorize' => false
//                    ),
//                    'configuration-myfx'  =>  array(
//                        'title' => 'Configurações Myfx',
//                        'route' => '/admin-module/configuration-myfx',
//                        'authorize' => false
//                    ),
//                ),
//            ),
            'site'     =>  array(
                'title'     =>  'Acessar o Site',
                'icon'      =>  'fa-desktop txt-color-blue',
                'route'     =>  '/auth',
            ),
            'logout'     =>  array(
                'title'     =>  'Deslogar',
                'icon'      =>  'fa-sign-out txt-color-red',
                'route'     =>  '/auth/logout',
            ),
        );
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

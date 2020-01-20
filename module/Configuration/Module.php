<?php
namespace Configuration;

class Module{
    public function getConfig(){
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig(){
        return array(
            'factories' => array(
                'Configuration\Service\Configuration' => function ($sm)
                {
                    return new Service\Configuration($sm->get('Doctrine\ORM\EntityManager'));
                },
                'Configuration\Form\Configuration' => function ($sm)
                {
                    return new Form\Configuration($sm->get('Doctrine\ORM\EntityManager'));
                },
                'Configuration\Service\Layout' => function ($sm)
                {
                    return new Service\Layout($sm->get('Doctrine\ORM\EntityManager'));
                },
                'Configuration\Form\Layout' => function ($sm)
                {
                    return new Form\Layout($sm->get('Doctrine\ORM\EntityManager'));
                },
                'Configuration\Service\LayoutOption' => function ($sm)
                {
                    return new Service\LayoutOption($sm->get('Doctrine\ORM\EntityManager'));
                },
                'Configuration\Form\LayoutOption' => function ($sm)
                {
                    return new Form\LayoutOption($sm->get('Doctrine\ORM\EntityManager'));
                }
            )
        );
    }

    public function getViewHelperConfig(){

        return array(
            'invokables' => array(
                'getConfiguracao' => __NAMESPACE__ . '\View\Helper\GetConfiguracao',
            )
        );
    }
}
?>
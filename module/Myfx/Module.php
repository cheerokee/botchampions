<?php
namespace Myfx;

use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

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
                'Myfx\Service\GraphPerformance' => function ($sm)
                {
                    return new Service\GraphPerformance($sm->get('Doctrine\ORM\EntityManager'));
                },
                'Myfx\Form\GraphPerformance' => function ($sm)
                {
                    return new Form\GraphPerformance($sm->get('Doctrine\ORM\EntityManager'));
                },
                'Myfx\Service\ConfigurationMyfx' => function ($sm)
                {
                    return new Service\ConfigurationMyfx($sm->get('Doctrine\ORM\EntityManager'));
                },
                'Myfx\Form\ConfigurationMyfx' => function ($sm)
                {
                    return new Form\ConfigurationMyfx($sm->get('Doctrine\ORM\EntityManager'));
                },
            )
        );
    }

    public function getViewHelperConfig(){

        return array(
            'invokables' => array(
                'getSession' => __NAMESPACE__ . '\View\Helper\GetSession',
                'testSession' => __NAMESPACE__ . '\View\Helper\TestSession',
                'getChartPerformance' => __NAMESPACE__ . '\View\Helper\GetChartPerformance',
            )
        );
    }

}

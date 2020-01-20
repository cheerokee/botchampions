<?php
namespace EA;

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
                'EA\Service\EA' => function ($sm)
                {
                    $service = new Service\EA($sm->get('Doctrine\ORM\EntityManager'),
                        $sm->get('Admin\Mail\Transport'),
                        $sm->get('View'));
                    $service->setConfigurationMail($sm->get('Config'));
                    return $service;
                },
                'EA\Form\EA' => function ($sm)
                {
                    return new Form\EA($sm->get('Doctrine\ORM\EntityManager'));
                },

                'EA\Service\EAContract' => function ($sm)
                {
                    $service = new Service\EAContract($sm->get('Doctrine\ORM\EntityManager'),
                        $sm->get('Admin\Mail\Transport'),
                        $sm->get('View'));
                    $service->setConfigurationMail($sm->get('Config'));
                    return $service;
                },
                'EA\Form\EAContract' => function ($sm)
                {
                    return new Form\EAContract($sm->get('Doctrine\ORM\EntityManager'));
                },

                'EA\Service\EAXMAccount' => function ($sm)
                {
                    return new Service\EAXMAccount($sm->get('Doctrine\ORM\EntityManager'));
                },
                'EA\Form\EAXMAccount' => function ($sm)
                {
                    return new Form\EAXMAccount($sm->get('Doctrine\ORM\EntityManager'));
                },

                'EA\Service\EARequestPayment' => function ($sm)
                {
                    $service = new Service\EARequestPayment($sm->get('Doctrine\ORM\EntityManager'),
                        $sm->get('Admin\Mail\Transport'),
                        $sm->get('View'));
                    $service->setConfigurationMail($sm->get('Config'));
                    return $service;
                },
                'EA\Form\EARequestPayment' => function ($sm)
                {
                    return new Form\EARequestPayment($sm->get('Doctrine\ORM\EntityManager'));
                },

                'EA\Service\EAYield' => function ($sm)
                {
                    return new Service\EAYield($sm->get('Doctrine\ORM\EntityManager'));
                },

                'EA\Service\EAConfiguration' => function ($sm)
                {
                    return new Service\EAConfiguration($sm->get('Doctrine\ORM\EntityManager'));
                },
                'EA\Form\EAConfiguration' => function ($sm)
                {
                    return new Form\EAConfiguration($sm->get('Doctrine\ORM\EntityManager'));
                },

                'EA\Service\EAPrice' => function ($sm)
                {
                    return new Service\EAPrice($sm->get('Doctrine\ORM\EntityManager'));
                },
                'EA\Form\EAPrice' => function ($sm)
                {
                    return new Form\EAPrice($sm->get('Doctrine\ORM\EntityManager'));
                },

            )
        );
    }

    public function getViewHelperConfig(){

        return array(
            'invokables' => array(
                'getConfiguracaoEA' => __NAMESPACE__ . '\View\Helper\GetConfiguracaoEa',
            )
        );
    }

}

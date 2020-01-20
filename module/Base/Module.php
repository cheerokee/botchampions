<?php

namespace Base;

class Module
{
    
    public function getConfig()
    {
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

    public function getViewHelperConfig(){
        return array(
            'invokables' => array(
                'getTexto' => __NAMESPACE__ . '\View\Helper\GetTexto',
                'rota' => 'Base\View\Helper\RotaHelper',
                'headListagem' => 'Base\View\Helper\Listagem\HeadListagem',
                'bodyListagem' => 'Base\View\Helper\Listagem\BodyListagem',
                'globalVars' => 'Base\View\Helper\GlobalVars',
                'formatCPF' => 'Base\View\Helper\FormatCPF',
                'formatCNPJ' => 'Base\View\Helper\FormatCNPJ',
                'formatCpfCnpj' => 'Base\View\Helper\FormatCpfCnpj',
                'formatCEP' => 'Base\View\Helper\FormatCEP',
                'getEm' => 'Base\View\Helper\GetEm',
            ),
        );
    }
}

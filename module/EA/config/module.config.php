<?php

namespace EA;

return array(
    'router' => array(
        'routes' => array(
            'panel-ea' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'=>'/admin-module/panel-ea[/:id]',
                    'constraints' => array(
                        'id' => '\d+'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'EA\Controller',
                        'controller' => 'Index',
                        'action' => 'panel-ea'
                    )
                )
            ),
            'request-payment' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'=>'/admin-module/request-payment',
                    'constraints' => array(
                        'id' => '\d+'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'EA\Controller',
                        'controller' => 'Index',
                        'action' => 'request-payment'
                    )
                )
            ),
            'yield-save' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'=>'/admin-module/yield-save',
                    'defaults' => array(
                        '__NAMESPACE__' => 'EA\Controller',
                        'controller' => 'EARequestPayment',
                        'action' => 'yield-save'
                    )
                )
            ),
            'ea' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin-module',
                    'defaults' => array(
                        '__NAMESPACE__' => 'EA\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'defaults' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/ea[/:action[/:id]][/page/:page][/order_by/:order_by][/:order]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+',
                                'page' => '\d+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => 'EA',
                                'action' => 'index'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[/:controller[/page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            )
                        )
                    )
                )
            ),
            'ea-contract' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin-module',
                    'defaults' => array(
                        '__NAMESPACE__' => 'EA\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'defaults' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/ea-contract[/:action[/:id]][/page/:page][/order_by/:order_by][/:order]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+',
                                'page' => '\d+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => 'EAContract',
                                'action' => 'index'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[/:controller[/page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            )
                        )
                    )
                )
            ),
            'blacklist-espelhamento' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin-module',
                    'defaults' => array(
                        '__NAMESPACE__' => 'EA\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'defaults' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/blacklist-espelhamento[/:action[/:id]][/page/:page][/order_by/:order_by][/:order]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+',
                                'page' => '\d+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => 'EAContract',
                                'action' => 'blacklist-espelhamento'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[/:controller[/page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            )
                        )
                    )
                )
            ),
            'ea-xm-account' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin-module',
                    'defaults' => array(
                        '__NAMESPACE__' => 'EA\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'defaults' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/ea-xm-account[/:action[/:id]][/page/:page][/order_by/:order_by][/:order]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+',
                                'page' => '\d+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => 'EAXMAccount',
                                'action' => 'index'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[/:controller[/page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            )
                        )
                    )
                )
            ),
            'ea-configuration' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin-module',
                    'defaults' => array(
                        '__NAMESPACE__' => 'EA\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'defaults' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/ea-configuration[/:action[/:id]][/page/:page][/order_by/:order_by][/:order]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+',
                                'page' => '\d+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => 'EAConfiguration',
                                'action' => 'index'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[/:controller[/page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            )
                        )
                    )
                )
            ),
            'ea-price' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin-module',
                    'defaults' => array(
                        '__NAMESPACE__' => 'EA\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'defaults' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/ea-price[/:action[/:id]][/page/:page][/order_by/:order_by][/:order]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+',
                                'page' => '\d+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => 'EAPrice',
                                'action' => 'index'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[/:controller[/page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            )
                        )
                    )
                )
            ),
            'ea-contract-save' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'=>'/admin-modulo/ea-contract-save',
                    'defaults' => array(
                        '__NAMESPACE__' => 'EA\Controller',
                        'controller' => 'Index',
                        'action' => 'ea-contract-save'
                    )
                )
            ),
            'ea-request-payment' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin-module',
                    'defaults' => array(
                        '__NAMESPACE__' => 'EA\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'defaults' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/ea-request-payment[/:action[/:id]][/page/:page][/order_by/:order_by][/:order]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+',
                                'page' => '\d+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => 'EARequestPayment',
                                'action' => 'index'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[/:controller[/page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            )
                        )
                    )
                )
            ),
            'ea-yield' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin-module',
                    'defaults' => array(
                        '__NAMESPACE__' => 'EA\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'defaults' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/ea-yield[/:action[/:id]][/page/:page][/order_by/:order_by][/:order]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+',
                                'page' => '\d+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => 'EAYield',
                                'action' => 'index'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[/:controller[/page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            )
                        )
                    )
                )
            ),
            'send-mail-request-payment' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'=>'/admin-module/send-mail-request-payment',
                    'defaults' => array(
                        '__NAMESPACE__' => 'EA\Controller',
                        'controller' => 'EARequestPayment',
                        'action' => 'send-mail-request-payment'
                    )
                )
            ),
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'EA\Controller\Index'           => 'EA\Controller\IndexController',
            'EA\Controller\EA'              => 'EA\Controller\EAController',
            'EA\Controller\EAContract'      => 'EA\Controller\EAContractController',
            'EA\Controller\EAXMAccount'     => 'EA\Controller\EAXMAccountController',
            'EA\Controller\EAConfiguration' => 'EA\Controller\EAConfigurationController',
            'EA\Controller\EAPrice'         => 'EA\Controller\EAPriceController',
            'EA\Controller\EARequestPayment' => 'EA\Controller\EARequestPaymentController',
            'EA\Controller\EAYield'         => 'EA\Controller\EAYieldController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);

<?php

namespace Myfx;

return array(
    'router' => array(
        'routes' => array(
            'graph-performance' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin-module',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Myfx\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'defaults' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/graph-performance[/:action[/:id]][/page/:page][/order_by/:order_by][/:order]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+',
                                'page' => '\d+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => 'GraphPerformance',
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
            'configuration-myfx' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin-module',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Myfx\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'defaults' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/configuration-myfx[/:action[/:id]][/page/:page][/order_by/:order_by][/:order]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+',
                                'page' => '\d+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => 'ConfigurationMyfx',
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
            'Myfx\Controller\GraphPerformance' => 'Myfx\Controller\GraphPerformanceController',
            'Myfx\Controller\ConfigurationMyfx' => 'Myfx\Controller\ConfigurationMyfxController',
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
            'error/index'             => __DIR__ . '/../view/error/index.phtml'
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

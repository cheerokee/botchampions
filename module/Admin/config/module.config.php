<?php

namespace Admin;

return array(
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'defaults' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action[/:id]][/page/:page][/order_by/:order_by][/:order]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+',
                                'page' => '\d+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                                'controller' => 'Index',
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
                                '__NAMESPACE__' => 'Admin\Controller',
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            )

                        )
                    )
                )
            ),

            'register' => array(
                //Rota Hardcoded, fixa, exatamente como � colocada
                'type' => 'Literal',
                'options' => array(
                    'route' => '/register',
                    'defaults' => array(
                        //Definindo o namespace da rota
                        '__NAMESPACE__' => 'Admin\Controller',
                        //Como o namespace ja foi setado em cima em vez de colocar SONUser\Controller\Index
                        //Podemos colocar apenas Index
                        'controller' => 'Index',
                        //Tendo a action com esse nome deve ser criado dentro de view/nomemodulo/register.phtml
                        'action' => 'register',
                    )
                )
            ),

            'sonuser-activate' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/register/activate[/:key]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Index',
                        'action' => 'activate'
                    )
                )
            ),
            'mail-lostPassword' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/mailer/mail-lostPassword',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\AuthController',
                        'action' => 'lostpassword'
                    )
                )
            ),
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'sonuser-auth' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/auth',
                    'defaults' => array(
                        '__NAMESPACE__'=>'Admin\Controller',
                        'controller'=>'Auth',
                        'action'=>'index'
                    )
                )
            ),
            'sonuser-logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/auth/logout',
                    'defaults' => array(
                        '__NAMESPACE__'=>'Admin\Controller',
                        'controller'=>'Auth',
                        'action'=>'logout'
                    )
                )
            ),
            'lostpassword' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/auth/lostpassword',
                    'defaults' => array(
                        '__NAMESPACE__'=>'Admin\Controller',
                        'controller'=>'Auth',
                        'action'=>'lostpassword'
                    )
                )
            ),
            'user-new' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/users/new',
                    'defaults' => array(
                        '__NAMESPACE__'=>'Admin\Controller',
                        'controller'=>'Users',
                        'action'=>'new'
                    )
                )
            ),
            'default' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/index/default',
                    'defaults' => array(
                        '__NAMESPACE__'=>'Admin\Controller',
                        'controller'=>'Index',
                        'action'=>'default'
                    )
                )
            ),
            'user-conta' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/user-conta[/:action[/:id]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Admin\Controller',
                                'controller' => 'user-conta'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/user-conta[/page/:page]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Admin\Controller',
                                'controller' => 'user-conta'
                            )
                        )
                    )
                )
            ),
            'user-conta-edit' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'=>'/admin/user-conta/edit[/:id]',
                    'constraints' => array(
                        'id' => '\d+'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'UserConta',
                        'action' => 'edit'
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
        ),
        'configuration' => array(
            'orm_default' => array(
                'string_functions' => array(
                    'Year' => 'DoctrineExtensions\Query\Mysql\Year',
                    'Date' => 'DoctrineExtensions\Query\Mysql\Date',
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
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Users' => 'Admin\Controller\UsersController',
            'Admin\Controller\Auth' => 'Admin\Controller\AuthController',
            'Admin\Controller\Perfil' => 'Admin\Controller\PerfilController',
            'Admin\Controller\UserConta' => 'Admin\Controller\UserContaController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'aporte-fifa'           => __DIR__ . '/../view/partials/aporte-fifa.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);

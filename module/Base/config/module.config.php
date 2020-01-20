<?php
namespace Base;

use Base\Delegator\TranslatorDelegator;

return array(
    'base' => array(
        'list_view' => array(
            'actions' => array(
                'enable' =>true,
                'defaults' => array(
                    'edit' => array(
                        'action' => 'edit',
                        'enable' => true,
                        'label' => 'Editar',
                        'class' => 'btn btn-success',
                        'icon' => 'glyphicon glyphicon-edit',
                    ),
                    'delete' => array(
                        'action' => 'delete',
                        'enable' => true,
                        'label' => 'Remover',
                        'class' => 'btn btn-danger',
                        'icon' => 'glyphicon glyphicon-trash',
                    ),
                    'view' => array(
                        'action' => 'view',
                        'enable' => true,
                        'label' => 'Visualizar',
                        'class' => 'btn btn-primary',
                        'icon' => 'glyphicon glyphicon-eye-open',
                    ),
                ),
            ),
        ),
    ),
    'asset_bundle' => array(
        'assets' => array(
            'less' => array('@zfRootPath/vendor/twitter/bootstrap/less/bootstrap.less')
        )
    ),
//     'controllers' => array(
//         'invokables' => array(
//             'Base\Controller\Search' => 'Base\Controller\SearchController',
//             'Base\Controller\Bug' => 'Base\Controller\BugController',
//             'Base\Controller\Migrate' => 'Base\Controller\MigrateController'
//         ),
//     ),
    
//     'form_elements' => array(
//         'factories' => array(
//             'Base\Form\Element\ObjectAutocomplete' => 'Base\Form\Element\ObjectAutocomplete',
//             'formAngular' => 'TwbBundle\Form\View\Helper\Factory\TwbBundleFormElementFactory',
//             'Base\Form\Element\Combobox' => 'Base\Form\Element\Combobox',
//         ),
//     ),
     'view_helpers' => array(
         'invokables' => array(
             'mostraoptions' => 'Base\View\Helper\MostraOptions',
             'formpesquisa' => 'Base\View\Helper\FormPesquisa',
             'formRow' => 'Base\Form\View\Helper\TwbBundleFormRow',
             'formAngular' => 'Base\Form\View\Helper\AngularBundleFormElement',
             'formMultiCheckbox' => 'Base\Form\View\Helper\TwbBundleFormMultiCheckbox',
             'templatedFormCollection' => \Base\View\Helper\TemplatedFormCollection::class,
             'templatedCollection' => \Base\View\Helper\TemplatedCollection::class,
             'TdField' => \Base\View\Helper\TdField::class,
             'migratesUpdate' => \Base\View\Helper\MigratesUpdate::class,
         ),
     ),
//     'service_manager' => array(
//         'delegators' => [
//             'MvcTranslator' => [
//                 TranslatorDelegator::class
//             ],
//         ],
//         'factories' => array(
//             'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
//         ),
//     ),
//     'translator' => array(
//         'translation_file_patterns' => array(
//             array(
//                 'type' => 'gettext',
//                 'base_dir' => 'language',
//                 'pattern' => '%s.mo'
//             ),
//         ),
//     ),
//     'navigation' => array(
//         'default'=> array(
//             'home' => array(
//                 'label' => 'Home',
//                 'route' => 'home',
//                 'uri' => '',
//                 'order' => 0,
//                 'icon' => 'glyphicon glyphicon-home',
//             ),
//         ),
//         'baseadmin'=> array(
//             'home' => array(
//                 'label' => 'Home',
//                 'route' => 'home',
//                 'uri' => '',
//                 'order' => 1,
//                 'icon' => 'glyphicon glyphicon-home',
//             ),
//         ),
//     ),
    'router' => array(
        'routes' => array(            
            'base' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/base',
                    'defaults' => array(
                        '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
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
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
            'submenu' => __DIR__ . '/../view/partials/submenu.phtml',
            'filter-base' => __DIR__ . '/../view/partials/filter-base.phtml',
            'filter/autocomplete' => __DIR__ . '/../view/partials/filter/autocomplete.phtml',
            'filter/texto' => __DIR__ . '/../view/partials/filter/texto.phtml',
            'filter/select' => __DIR__ . '/../view/partials/filter/select.phtml',
            'filter/custom' => __DIR__ . '/../view/partials/filter/custom.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view'
        ),
        'strategies' => array(
            'ViewJsonStrategy'
        ),
    ),
//     'module_layouts' => array(
//         'Base' => 'base/layout',
        
//     ),
    'doctrine' => array(
//         'migrations_configuration' => array(
//             'orm_default' => array(
//                 'directory' => 'data/DoctrineORMModule/Migrations',
//                 'name' => 'Migrações',
//                 'namespace' => 'DoctrineORMModule\Migrations',
//                 'table' => 'migrations',
//                 'column' => 'version',
//             ),
//         ),
//         'configuration' => array(
//             'orm_default' => array(
//                 // Custom DQL functions.
//                 // You can grab common MySQL ones at https://github.com/beberlei/DoctrineExtensions
//                 // Further docs at http://docs.doctrine-project.org/en/latest/cookbook/dql-user-defined-functions.html
//                 'numeric_functions' => array(
//                     'acos'  => 'DoctrineExtensions\Query\Mysql\Acos',
//                     'asin' => 'DoctrineExtensions\Query\Mysql\Asin',
//                     'atan2' => 'DoctrineExtensions\Query\Mysql\Atan2',
//                     'atan' => 'DoctrineExtensions\Query\Mysql\Atan',
//                     'cos' => 'DoctrineExtensions\Query\Mysql\Cos',
//                     'cot' => 'DoctrineExtensions\Query\Mysql\Cot',
//                     'hour' => 'DoctrineExtensions\Query\Mysql\Hour',
//                     'pi' => 'DoctrineExtensions\Query\Mysql\Pi',
//                     'power' => 'DoctrineExtensions\Query\Mysql\Power',
//                     'quarter' => 'DoctrineExtensions\Query\Mysql\Quarter',
//                     'rand' => 'DoctrineExtensions\Query\Mysql\Rand',
//                     'round' => 'Base\DQL\Round',
//                     'sin' => 'DoctrineExtensions\Query\Mysql\Sin',
//                     'std' => 'DoctrineExtensions\Query\Mysql\Std',
//                     'tan' => 'DoctrineExtensions\Query\Mysql\Tan',
//                 ),
//                 'datetime_functions' => array(
//                     'date' => 'DoctrineExtensions\Query\Mysql\Date',
//                     'date_format' => 'DoctrineExtensions\Query\Mysql\DateFormat',
//                     'dateadd' => 'DoctrineExtensions\Query\Mysql\DateAdd',
//                     'datediff' => 'DoctrineExtensions\Query\Mysql\DateDiff',
//                     'day' => 'DoctrineExtensions\Query\Mysql\Day',
//                     'dayname' => 'DoctrineExtensions\Query\Mysql\DayName',
//                     'last_day' => 'DoctrineExtensions\Query\Mysql\LastDay',
//                     'minute' => 'DoctrineExtensions\Query\Mysql\Minute',
//                     'second' => 'DoctrineExtensions\Query\Mysql\Second',
//                     'strtodate' => 'DoctrineExtensions\Query\Mysql\StrToDate',
//                     'time' => 'DoctrineExtensions\Query\Mysql\Time',
//                     'timestampadd' => 'DoctrineExtensions\Query\Mysql\TimestampAdd',
//                     'timestampdiff' => 'DoctrineExtensions\Query\Mysql\TimestampDiff',
//                     'week' => 'DoctrineExtensions\Query\Mysql\Week',
//                     'weekday' => 'DoctrineExtensions\Query\Mysql\WeekDay',
//                     'year' => 'DoctrineExtensions\Query\Mysql\Year',
//                 ),
//                 'string_functions'   => array(
//                     'binary' => 'DoctrineExtensions\Query\Mysql\Binary',
//                     'char_length' => 'DoctrineExtensions\Query\Mysql\CharLength',
//                     'concat_ws' => 'DoctrineExtensions\Query\Mysql\ConcatWs',
//                     'countif' => 'DoctrineExtensions\Query\Mysql\CountIf',
//                     'crc32' => ' DoctrineExtensions\Query\Mysql\Crc32',
//                     'degrees' => 'DoctrineExtensions\Query\Mysql\Degrees',
//                     'field' => 'DoctrineExtensions\Query\Mysql\Field',
//                     'find_in_set' => 'DoctrineExtensions\Query\Mysql\FindInSet',
//                     'group_concat' => 'DoctrineExtensions\Query\Mysql\GroupConcat',
//                     'ifelse' => 'DoctrineExtensions\Query\Mysql\IfElse',
//                     'ifnull' => 'DoctrineExtensions\Query\Mysql\IfNull',
//                     'match_against' => 'DoctrineExtensions\Query\Mysql\MatchAgainst',
//                     'md5' => 'DoctrineExtensions\Query\Mysql\Md5',
//                     'month' => 'DoctrineExtensions\Query\Mysql\Month',
//                     'monthname' => 'DoctrineExtensions\Query\Mysql\MonthName',
//                     'nullif' => 'DoctrineExtensions\Query\Mysql\NullIf',
//                     'radians' => 'DoctrineExtensions\Query\Mysql\Radians',
//                     'regexp' => 'DoctrineExtensions\Query\Mysql\Regexp',
//                     'replace' => 'DoctrineExtensions\Query\Mysql\Replace',
//                     'sha1' => 'DoctrineExtensions\Query\Mysql\Sha1',
//                     'sha2' => 'DoctrineExtensions\Query\Mysql\Sha2',
//                     'soundex' => 'DoctrineExtensions\Query\Mysql\Soundex',
//                     'uuid_short' => 'DoctrineExtensions\Query\Mysql\UuidShort',
//                 ),
//             ),
//         ),
//         'driver' => array(
//             __NAMESPACE__ . '_driver' => array(
//                 'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
//                 'cache' => 'array',
//                 'paths' => array(
//                     __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
//                 )
//             ),
//             'orm_default' => array(
//                 'drivers' => array(
//                     __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
//                 ),
//             ),
//         ),
    ),
);
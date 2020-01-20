<?php
return array(
    'router' => array(
        'routes' => array(
            'api.rest.doctrine.user' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/user[/:user_id]',
                    'defaults' => array(
                        'controller' => 'api\\V1\\Rest\\User\\Controller',
                    ),
                ),
            ),
            'api.rest.doctrine.configuration' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/configuration[/:configuration_id]',
                    'defaults' => array(
                        'controller' => 'api\\V1\\Rest\\Configuration\\Controller',
                    ),
                ),
            ),
            'api.rest.doctrine.user-conta' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/user-conta[/:user_conta_id]',
                    'defaults' => array(
                        'controller' => 'api\\V1\\Rest\\UserConta\\Controller',
                    ),
                ),
            ),
            'api.rest.doctrine.layout-option' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/layout-option[/:layout_option_id]',
                    'defaults' => array(
                        'controller' => 'api\\V1\\Rest\\LayoutOption\\Controller',
                    ),
                ),
            ),
            'api.rest.doctrine.ea' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/ea[/:ea_id]',
                    'defaults' => array(
                        'controller' => 'api\\V1\\Rest\\EA\\Controller',
                    ),
                ),
            ),
            'api.rest.doctrine.ea-contract' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/ea-contract[/:ea_contract_id]',
                    'defaults' => array(
                        'controller' => 'api\\V1\\Rest\\EAContract\\Controller',
                    ),
                ),
            ),
            'api.rest.doctrine.eaxm-account' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/eaxm-account[/:eaxm_account_id]',
                    'defaults' => array(
                        'controller' => 'api\\V1\\Rest\\EAXMAccount\\Controller',
                    ),
                ),
            ),
            'api.rest.doctrine.ea-configuration' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/ea-configuration[/:ea_configuration_id]',
                    'defaults' => array(
                        'controller' => 'api\\V1\\Rest\\EAConfiguration\\Controller',
                    ),
                ),
            ),
            'api.rest.doctrine.ea-price' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/ea-price[/:ea_price_id]',
                    'defaults' => array(
                        'controller' => 'api\\V1\\Rest\\EAPrice\\Controller',
                    ),
                ),
            ),
            'api.rest.doctrine.configuration-myfx' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/configuration-myfx[/:configuration_myfx_id]',
                    'defaults' => array(
                        'controller' => 'api\\V1\\Rest\\ConfigurationMyfx\\Controller',
                    ),
                ),
            ),
            'api.rest.doctrine.graph-performance' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/graph-performance[/:graph_performance_id]',
                    'defaults' => array(
                        'controller' => 'api\\V1\\Rest\\GraphPerformance\\Controller',
                    ),
                ),
            ),
            'api.rest.doctrine.ea-yield' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/ea-yield[/:ea_yield_id]',
                    'defaults' => array(
                        'controller' => 'api\\V1\\Rest\\EAYield\\Controller',
                    ),
                ),
            ),
            'api.rest.doctrine.ea-request-payment' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/ea-request-payment[/:ea_request_payment_id]',
                    'defaults' => array(
                        'controller' => 'api\\V1\\Rest\\EARequestPayment\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'api.rest.doctrine.user',
            3 => 'api.rest.doctrine.configuration',
            4 => 'api.rest.doctrine.user-conta',
            5 => 'api.rest.doctrine.layout-option',
            11 => 'api.rest.doctrine.ea',
            12 => 'api.rest.doctrine.ea-contract',
            13 => 'api.rest.doctrine.eaxm-account',
            14 => 'api.rest.doctrine.ea-configuration',
            15 => 'api.rest.doctrine.ea-price',
            18 => 'api.rest.doctrine.configuration-myfx',
            19 => 'api.rest.doctrine.graph-performance',
            20 => 'api.rest.doctrine.ea-yield',
            21 => 'api.rest.doctrine.ea-request-payment',
        ),
    ),
    'zf-rest' => array(
        'api\\V1\\Rest\\User\\Controller' => array(
            'listener' => 'api\\V1\\Rest\\User\\UserResource',
            'route_name' => 'api.rest.doctrine.user',
            'route_identifier_name' => 'user_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'user',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Admin\\Entity\\User',
            'collection_class' => 'api\\V1\\Rest\\User\\UserCollection',
            'service_name' => 'User',
        ),
        'api\\V1\\Rest\\Configuration\\Controller' => array(
            'listener' => 'api\\V1\\Rest\\Configuration\\ConfigurationResource',
            'route_name' => 'api.rest.doctrine.configuration',
            'route_identifier_name' => 'configuration_id',
            'entity_identifier_name' => 'chave',
            'collection_name' => 'configuration',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Configuration\\Entity\\Configuration',
            'collection_class' => 'api\\V1\\Rest\\Configuration\\ConfigurationCollection',
            'service_name' => 'Configuration',
        ),
        'api\\V1\\Rest\\UserConta\\Controller' => array(
            'listener' => 'api\\V1\\Rest\\UserConta\\UserContaResource',
            'route_name' => 'api.rest.doctrine.user-conta',
            'route_identifier_name' => 'user_conta_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'user_conta',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Admin\\Entity\\UserConta',
            'collection_class' => 'api\\V1\\Rest\\UserConta\\UserContaCollection',
            'service_name' => 'UserConta',
        ),
        'api\\V1\\Rest\\LayoutOption\\Controller' => array(
            'listener' => 'api\\V1\\Rest\\LayoutOption\\LayoutOptionResource',
            'route_name' => 'api.rest.doctrine.layout-option',
            'route_identifier_name' => 'layout_option_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'layout_option',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Configuration\\Entity\\LayoutOption',
            'collection_class' => 'api\\V1\\Rest\\LayoutOption\\LayoutOptionCollection',
            'service_name' => 'LayoutOption',
        ),
        'api\\V1\\Rest\\EA\\Controller' => array(
            'listener' => 'api\\V1\\Rest\\EA\\EAResource',
            'route_name' => 'api.rest.doctrine.ea',
            'route_identifier_name' => 'ea_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'ea',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'EA\\Entity\\EA',
            'collection_class' => 'api\\V1\\Rest\\EA\\EACollection',
            'service_name' => 'EA',
        ),
        'api\\V1\\Rest\\EAContract\\Controller' => array(
            'listener' => 'api\\V1\\Rest\\EAContract\\EAContractResource',
            'route_name' => 'api.rest.doctrine.ea-contract',
            'route_identifier_name' => 'ea_contract_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'ea_contract',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'EA\\Entity\\EAContract',
            'collection_class' => 'api\\V1\\Rest\\EAContract\\EAContractCollection',
            'service_name' => 'EAContract',
        ),
        'api\\V1\\Rest\\EAXMAccount\\Controller' => array(
            'listener' => 'api\\V1\\Rest\\EAXMAccount\\EAXMAccountResource',
            'route_name' => 'api.rest.doctrine.eaxm-account',
            'route_identifier_name' => 'eaxm_account_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'eaxm_account',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
                2 => 'PATCH',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'EA\\Entity\\EAXMAccount',
            'collection_class' => 'api\\V1\\Rest\\EAXMAccount\\EAXMAccountCollection',
            'service_name' => 'EAXMAccount',
        ),
        'api\\V1\\Rest\\EAConfiguration\\Controller' => array(
            'listener' => 'api\\V1\\Rest\\EAConfiguration\\EAConfigurationResource',
            'route_name' => 'api.rest.doctrine.ea-configuration',
            'route_identifier_name' => 'ea_configuration_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'ea_configuration',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'EA\\Entity\\EAConfiguration',
            'collection_class' => 'api\\V1\\Rest\\EAConfiguration\\EAConfigurationCollection',
            'service_name' => 'EAConfiguration',
        ),
        'api\\V1\\Rest\\EAPrice\\Controller' => array(
            'listener' => 'api\\V1\\Rest\\EAPrice\\EAPriceResource',
            'route_name' => 'api.rest.doctrine.ea-price',
            'route_identifier_name' => 'ea_price_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'ea_price',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'EA\\Entity\\EAPrice',
            'collection_class' => 'api\\V1\\Rest\\EAPrice\\EAPriceCollection',
            'service_name' => 'EAPrice',
        ),
        'api\\V1\\Rest\\ConfigurationMyfx\\Controller' => array(
            'listener' => 'api\\V1\\Rest\\ConfigurationMyfx\\ConfigurationMyfxResource',
            'route_name' => 'api.rest.doctrine.configuration-myfx',
            'route_identifier_name' => 'configuration_myfx_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'configuration_myfx',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Myfx\\Entity\\ConfigurationMyfx',
            'collection_class' => 'api\\V1\\Rest\\ConfigurationMyfx\\ConfigurationMyfxCollection',
            'service_name' => 'ConfigurationMyfx',
        ),
        'api\\V1\\Rest\\GraphPerformance\\Controller' => array(
            'listener' => 'api\\V1\\Rest\\GraphPerformance\\GraphPerformanceResource',
            'route_name' => 'api.rest.doctrine.graph-performance',
            'route_identifier_name' => 'graph_performance_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'graph_performance',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Myfx\\Entity\\GraphPerformance',
            'collection_class' => 'api\\V1\\Rest\\GraphPerformance\\GraphPerformanceCollection',
            'service_name' => 'GraphPerformance',
        ),
        'api\\V1\\Rest\\EAYield\\Controller' => array(
            'listener' => 'api\\V1\\Rest\\EAYield\\EAYieldResource',
            'route_name' => 'api.rest.doctrine.ea-yield',
            'route_identifier_name' => 'ea_yield_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'ea_yield',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => '25',
            'page_size_param' => null,
            'entity_class' => 'EA\\Entity\\EAYield',
            'collection_class' => 'api\\V1\\Rest\\EAYield\\EAYieldCollection',
            'service_name' => 'EAYield',
        ),
        'api\\V1\\Rest\\EARequestPayment\\Controller' => array(
            'listener' => 'api\\V1\\Rest\\EARequestPayment\\EARequestPaymentResource',
            'route_name' => 'api.rest.doctrine.ea-request-payment',
            'route_identifier_name' => 'ea_request_payment_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'ea_request_payment',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'EA\\Entity\\EARequestPayment',
            'collection_class' => 'api\\V1\\Rest\\EARequestPayment\\EARequestPaymentCollection',
            'service_name' => 'EARequestPayment',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'api\\V1\\Rest\\User\\Controller' => 'HalJson',
            'api\\V1\\Rest\\Configuration\\Controller' => 'HalJson',
            'api\\V1\\Rest\\UserConta\\Controller' => 'HalJson',
            'api\\V1\\Rest\\LayoutOption\\Controller' => 'HalJson',
            'api\\V1\\Rest\\EA\\Controller' => 'HalJson',
            'api\\V1\\Rest\\EAContract\\Controller' => 'HalJson',
            'api\\V1\\Rest\\EAXMAccount\\Controller' => 'HalJson',
            'api\\V1\\Rest\\EAConfiguration\\Controller' => 'HalJson',
            'api\\V1\\Rest\\EAPrice\\Controller' => 'HalJson',
            'api\\V1\\Rest\\ConfigurationMyfx\\Controller' => 'HalJson',
            'api\\V1\\Rest\\GraphPerformance\\Controller' => 'HalJson',
            'api\\V1\\Rest\\EAYield\\Controller' => 'HalJson',
            'api\\V1\\Rest\\EARequestPayment\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'api\\V1\\Rest\\User\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'api\\V1\\Rest\\Configuration\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'api\\V1\\Rest\\UserConta\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'api\\V1\\Rest\\LayoutOption\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'api\\V1\\Rest\\EA\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'api\\V1\\Rest\\EAContract\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'api\\V1\\Rest\\EAXMAccount\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'api\\V1\\Rest\\EAConfiguration\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'api\\V1\\Rest\\EAPrice\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'api\\V1\\Rest\\ConfigurationMyfx\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'api\\V1\\Rest\\GraphPerformance\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'api\\V1\\Rest\\EAYield\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'api\\V1\\Rest\\EARequestPayment\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'api\\V1\\Rest\\User\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
            'api\\V1\\Rest\\Configuration\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
            'api\\V1\\Rest\\UserConta\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
            'api\\V1\\Rest\\LayoutOption\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
            'api\\V1\\Rest\\EA\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
            'api\\V1\\Rest\\EAContract\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
            'api\\V1\\Rest\\EAXMAccount\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
            'api\\V1\\Rest\\EAConfiguration\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
            'api\\V1\\Rest\\EAPrice\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
            'api\\V1\\Rest\\ConfigurationMyfx\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
            'api\\V1\\Rest\\GraphPerformance\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
            'api\\V1\\Rest\\EAYield\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
            'api\\V1\\Rest\\EARequestPayment\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Admin\\Entity\\User' => array(
                'route_identifier_name' => 'user_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.user',
                'hydrator' => 'api\\V1\\Rest\\User\\UserHydrator',
            ),
            'api\\V1\\Rest\\User\\UserCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.user',
                'is_collection' => true,
            ),
            'Configuration\\Entity\\Configuration' => array(
                'route_identifier_name' => 'configuration_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.configuration',
                'hydrator' => 'api\\V1\\Rest\\Configuration\\ConfigurationHydrator',
            ),
            'api\\V1\\Rest\\Configuration\\ConfigurationCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.configuration',
                'is_collection' => true,
            ),
            'Admin\\Entity\\UserConta' => array(
                'route_identifier_name' => 'user_conta_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.user-conta',
                'hydrator' => 'api\\V1\\Rest\\UserConta\\UserContaHydrator',
            ),
            'api\\V1\\Rest\\UserConta\\UserContaCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.user-conta',
                'is_collection' => true,
            ),
            'Configuration\\Entity\\LayoutOption' => array(
                'route_identifier_name' => 'layout_option_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.layout-option',
                'hydrator' => 'api\\V1\\Rest\\LayoutOption\\LayoutOptionHydrator',
            ),
            'api\\V1\\Rest\\LayoutOption\\LayoutOptionCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.layout-option',
                'is_collection' => true,
            ),
            'EA\\Entity\\EA' => array(
                'route_identifier_name' => 'ea_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.ea',
                'hydrator' => 'api\\V1\\Rest\\EA\\EAHydrator',
            ),
            'api\\V1\\Rest\\EA\\EACollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.ea',
                'is_collection' => true,
            ),
            'EA\\Entity\\EAContract' => array(
                'route_identifier_name' => 'ea_contract_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.ea-contract',
                'hydrator' => 'api\\V1\\Rest\\EAContract\\EAContractHydrator',
            ),
            'api\\V1\\Rest\\EAContract\\EAContractCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.ea-contract',
                'is_collection' => true,
            ),
            'EA\\Entity\\EAXMAccount' => array(
                'route_identifier_name' => 'eaxm_account_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.eaxm-account',
                'hydrator' => 'api\\V1\\Rest\\EAXMAccount\\EAXMAccountHydrator',
            ),
            'api\\V1\\Rest\\EAXMAccount\\EAXMAccountCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.eaxm-account',
                'is_collection' => true,
            ),
            'EA\\Entity\\EAConfiguration' => array(
                'route_identifier_name' => 'ea_configuration_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.ea-configuration',
                'hydrator' => 'api\\V1\\Rest\\EAConfiguration\\EAConfigurationHydrator',
            ),
            'api\\V1\\Rest\\EAConfiguration\\EAConfigurationCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.ea-configuration',
                'is_collection' => true,
            ),
            'EA\\Entity\\EAPrice' => array(
                'route_identifier_name' => 'ea_price_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.ea-price',
                'hydrator' => 'api\\V1\\Rest\\EAPrice\\EAPriceHydrator',
            ),
            'api\\V1\\Rest\\EAPrice\\EAPriceCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.ea-price',
                'is_collection' => true,
            ),
            'Myfx\\Entity\\ConfigurationMyfx' => array(
                'route_identifier_name' => 'configuration_myfx_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.configuration-myfx',
                'hydrator' => 'api\\V1\\Rest\\ConfigurationMyfx\\ConfigurationMyfxHydrator',
            ),
            'api\\V1\\Rest\\ConfigurationMyfx\\ConfigurationMyfxCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.configuration-myfx',
                'is_collection' => true,
            ),
            'Myfx\\Entity\\GraphPerformance' => array(
                'route_identifier_name' => 'graph_performance_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.graph-performance',
                'hydrator' => 'api\\V1\\Rest\\GraphPerformance\\GraphPerformanceHydrator',
            ),
            'api\\V1\\Rest\\GraphPerformance\\GraphPerformanceCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.graph-performance',
                'is_collection' => true,
            ),
            'EA\\Entity\\EAYield' => array(
                'route_identifier_name' => 'ea_yield_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.ea-yield',
                'hydrator' => 'api\\V1\\Rest\\EAYield\\EAYieldHydrator',
            ),
            'api\\V1\\Rest\\EAYield\\EAYieldCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.ea-yield',
                'is_collection' => true,
            ),
            'EA\\Entity\\EARequestPayment' => array(
                'route_identifier_name' => 'ea_request_payment_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.ea-request-payment',
                'hydrator' => 'api\\V1\\Rest\\EARequestPayment\\EARequestPaymentHydrator',
            ),
            'api\\V1\\Rest\\EARequestPayment\\EARequestPaymentCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.ea-request-payment',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-apigility' => array(
        'doctrine-connected' => array(
            'api\\V1\\Rest\\User\\UserResource' => array(
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\User\\UserHydrator',
            ),
            'api\\V1\\Rest\\Configuration\\ConfigurationResource' => array(
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\Configuration\\ConfigurationHydrator',
            ),
            'api\\V1\\Rest\\UserConta\\UserContaResource' => array(
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\UserConta\\UserContaHydrator',
            ),
            'api\\V1\\Rest\\LayoutOption\\LayoutOptionResource' => array(
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\LayoutOption\\LayoutOptionHydrator',
            ),
            'api\\V1\\Rest\\EA\\EAResource' => array(
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\EA\\EAHydrator',
            ),
            'api\\V1\\Rest\\EAContract\\EAContractResource' => array(
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\EAContract\\EAContractHydrator',
            ),
            'api\\V1\\Rest\\EAXMAccount\\EAXMAccountResource' => array(
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\EAXMAccount\\EAXMAccountHydrator',
            ),
            'api\\V1\\Rest\\EAConfiguration\\EAConfigurationResource' => array(
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\EAConfiguration\\EAConfigurationHydrator',
            ),
            'api\\V1\\Rest\\EAPrice\\EAPriceResource' => array(
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\EAPrice\\EAPriceHydrator',
            ),
            'api\\V1\\Rest\\ConfigurationMyfx\\ConfigurationMyfxResource' => array(
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\ConfigurationMyfx\\ConfigurationMyfxHydrator',
            ),
            'api\\V1\\Rest\\GraphPerformance\\GraphPerformanceResource' => array(
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\GraphPerformance\\GraphPerformanceHydrator',
            ),
            'api\\V1\\Rest\\EAYield\\EAYieldResource' => array(
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\EAYield\\EAYieldHydrator',
            ),
            'api\\V1\\Rest\\EARequestPayment\\EARequestPaymentResource' => array(
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\EARequestPayment\\EARequestPaymentHydrator',
            ),
        ),
    ),
    'doctrine-hydrator' => array(
        'api\\V1\\Rest\\User\\UserHydrator' => array(
            'entity_class' => 'Admin\\Entity\\User',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => array(),
            'use_generated_hydrator' => true,
        ),
        'api\\V1\\Rest\\Configuration\\ConfigurationHydrator' => array(
            'entity_class' => 'Configuration\\Entity\\Configuration',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => array(),
            'use_generated_hydrator' => true,
        ),
        'api\\V1\\Rest\\UserConta\\UserContaHydrator' => array(
            'entity_class' => 'Admin\\Entity\\UserConta',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => array(),
            'use_generated_hydrator' => true,
        ),
        'api\\V1\\Rest\\LayoutOption\\LayoutOptionHydrator' => array(
            'entity_class' => 'Configuration\\Entity\\LayoutOption',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => array(),
            'use_generated_hydrator' => true,
        ),
        'api\\V1\\Rest\\EA\\EAHydrator' => array(
            'entity_class' => 'EA\\Entity\\EA',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => array(),
            'use_generated_hydrator' => true,
        ),
        'api\\V1\\Rest\\EAContract\\EAContractHydrator' => array(
            'entity_class' => 'EA\\Entity\\EAContract',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => array(),
            'use_generated_hydrator' => true,
        ),
        'api\\V1\\Rest\\EAXMAccount\\EAXMAccountHydrator' => array(
            'entity_class' => 'EA\\Entity\\EAXMAccount',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => array(),
            'use_generated_hydrator' => true,
        ),
        'api\\V1\\Rest\\EAConfiguration\\EAConfigurationHydrator' => array(
            'entity_class' => 'EA\\Entity\\EAConfiguration',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => array(),
            'use_generated_hydrator' => true,
        ),
        'api\\V1\\Rest\\EAPrice\\EAPriceHydrator' => array(
            'entity_class' => 'EA\\Entity\\EAPrice',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => array(),
            'use_generated_hydrator' => true,
        ),
        'api\\V1\\Rest\\ConfigurationMyfx\\ConfigurationMyfxHydrator' => array(
            'entity_class' => 'Myfx\\Entity\\ConfigurationMyfx',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => array(),
            'use_generated_hydrator' => true,
        ),
        'api\\V1\\Rest\\GraphPerformance\\GraphPerformanceHydrator' => array(
            'entity_class' => 'Myfx\\Entity\\GraphPerformance',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => array(),
            'use_generated_hydrator' => true,
        ),
        'api\\V1\\Rest\\EAYield\\EAYieldHydrator' => array(
            'entity_class' => 'EA\\Entity\\EAYield',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => array(),
            'use_generated_hydrator' => true,
        ),
        'api\\V1\\Rest\\EARequestPayment\\EARequestPaymentHydrator' => array(
            'entity_class' => 'EA\\Entity\\EARequestPayment',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => array(),
            'use_generated_hydrator' => true,
        ),
    ),
    'zf-content-validation' => array(
        'api\\V1\\Rest\\User\\Controller' => array(
            'input_filter' => 'api\\V1\\Rest\\User\\Validator',
        ),
        'api\\V1\\Rest\\Configuration\\Controller' => array(
            'input_filter' => 'api\\V1\\Rest\\Configuration\\Validator',
        ),
        'api\\V1\\Rest\\UserConta\\Controller' => array(
            'input_filter' => 'api\\V1\\Rest\\UserConta\\Validator',
        ),
        'api\\V1\\Rest\\LayoutOption\\Controller' => array(
            'input_filter' => 'api\\V1\\Rest\\LayoutOption\\Validator',
        ),
        'api\\V1\\Rest\\EA\\Controller' => array(
            'input_filter' => 'api\\V1\\Rest\\EA\\Validator',
        ),
        'api\\V1\\Rest\\EAContract\\Controller' => array(
            'input_filter' => 'api\\V1\\Rest\\EAContract\\Validator',
        ),
        'api\\V1\\Rest\\EAXMAccount\\Controller' => array(
            'input_filter' => 'api\\V1\\Rest\\EAXMAccount\\Validator',
        ),
        'api\\V1\\Rest\\EAConfiguration\\Controller' => array(
            'input_filter' => 'api\\V1\\Rest\\EAConfiguration\\Validator',
        ),
        'api\\V1\\Rest\\EAPrice\\Controller' => array(
            'input_filter' => 'api\\V1\\Rest\\EAPrice\\Validator',
        ),
        'api\\V1\\Rest\\ConfigurationMyfx\\Controller' => array(
            'input_filter' => 'api\\V1\\Rest\\ConfigurationMyfx\\Validator',
        ),
        'api\\V1\\Rest\\GraphPerformance\\Controller' => array(
            'input_filter' => 'api\\V1\\Rest\\GraphPerformance\\Validator',
        ),
        'api\\V1\\Rest\\EAYield\\Controller' => array(
            'input_filter' => 'api\\V1\\Rest\\EAYield\\Validator',
        ),
        'api\\V1\\Rest\\EARequestPayment\\Controller' => array(
            'input_filter' => 'api\\V1\\Rest\\EARequestPayment\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'api\\V1\\Rest\\User\\Validator' => array(
            0 => array(
                'name' => 'nome',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            1 => array(
                'name' => 'email',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            2 => array(
                'name' => 'password',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            3 => array(
                'name' => 'salt',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            4 => array(
                'name' => 'active',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            5 => array(
                'name' => 'activeKey',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            6 => array(
                'name' => 'updatedAt',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
            7 => array(
                'name' => 'createdAt',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
            8 => array(
                'name' => 'indicadoPor',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            9 => array(
                'name' => 'telefone',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            10 => array(
                'name' => 'whatsapp',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            11 => array(
                'name' => 'facebook',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            12 => array(
                'name' => 'cep',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            13 => array(
                'name' => 'endereco',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            14 => array(
                'name' => 'numero',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            15 => array(
                'name' => 'complemento',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            16 => array(
                'name' => 'bairro',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            17 => array(
                'name' => 'city',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            18 => array(
                'name' => 'state',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            19 => array(
                'name' => 'imagem',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            20 => array(
                'name' => 'isAdmin',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            21 => array(
                'name' => 'site',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            22 => array(
                'name' => 'conta_a',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            23 => array(
                'name' => 'bloco_a1',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            24 => array(
                'name' => 'bloco_a2',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            25 => array(
                'name' => 'conta_b',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            26 => array(
                'name' => 'bloco_b1',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            27 => array(
                'name' => 'bloco_b2',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            28 => array(
                'name' => 'senha_parametro',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            29 => array(
                'name' => 'parametro',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            30 => array(
                'name' => 'fanpage',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            31 => array(
                'name' => 'analize',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            32 => array(
                'name' => 'modo_godzilla',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            33 => array(
                'name' => 'contas',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            34 => array(
                'name' => 'exibe_bloco',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            35 => array(
                'name' => 'exibe_bloco_post',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            36 => array(
                'name' => 'random',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            37 => array(
                'name' => 'mereco_mais',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            38 => array(
                'name' => 'autoplay_merecemos_mais',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            39 => array(
                'name' => 'comprovante',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            40 => array(
                'name' => 'documento',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            41 => array(
                'name' => 'tipo_hotlink',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            42 => array(
                'name' => 'creditos',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            43 => array(
                'name' => 'comprovantecredito',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            44 => array(
                'name' => 'indicado_godzillaads',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            45 => array(
                'name' => 'data_ativacao',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            46 => array(
                'name' => 'novo_comprovante',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            47 => array(
                'name' => 'novo_documento',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            48 => array(
                'name' => 'banido',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            49 => array(
                'name' => 'status_mereco_mais',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            50 => array(
                'name' => 'banido_mereco_mais',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            51 => array(
                'name' => 'status_godzillaads',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            52 => array(
                'name' => 'cursoOpcoesBinarias',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            53 => array(
                'name' => 'rg',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
        ),
        'api\\V1\\Rest\\Configuration\\Validator' => array(
            0 => array(
                'name' => 'title',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 225,
                        ),
                    ),
                ),
            ),
            1 => array(
                'name' => 'chave',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            2 => array(
                'name' => 'value',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
        ),
        'api\\V1\\Rest\\UserConta\\Validator' => array(
            0 => array(
                'name' => 'cnpj',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            1 => array(
                'name' => 'banco',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            2 => array(
                'name' => 'agencia',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            3 => array(
                'name' => 'conta',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            5 => array(
                'name' => 'tipo',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            6 => array(
                'name' => 'ativo',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            8 => array(
                'name' => 'updatedAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            9 => array(
                'name' => 'createdAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
        ),
        'api\\V1\\Rest\\LayoutOption\\Validator' => array(
            0 => array(
                'name' => 'updatedAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            1 => array(
                'name' => 'createdAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            2 => array(
                'name' => 'title',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            3 => array(
                'name' => 'element',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            4 => array(
                'name' => 'active',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
        ),
        'api\\V1\\Rest\\EA\\Validator' => array(
            0 => array(
                'name' => 'updatedAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            1 => array(
                'name' => 'createdAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            2 => array(
                'name' => 'name',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            3 => array(
                'name' => 'price',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
            4 => array(
                'name' => 'active',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
        ),
        'api\\V1\\Rest\\EAContract\\Validator' => array(
            0 => array(
                'name' => 'updatedAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            1 => array(
                'name' => 'createdAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            2 => array(
                'name' => 'status',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\Digits',
                    ),
                ),
                'validators' => array(),
            ),
            3 => array(
                'name' => 'receipt',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            4 => array(
                'name' => 'date_start',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
            5 => array(
                'name' => 'date_finish',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            6 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(),
                'name' => 'observation',
            ),
            7 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(),
                'name' => 'value_in_account',
            ),
        ),
        'api\\V1\\Rest\\EAXMAccount\\Validator' => array(
            0 => array(
                'name' => 'updatedAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            1 => array(
                'name' => 'createdAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            2 => array(
                'name' => 'number',
                'required' => false,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            3 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'password',
            ),
            4 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'server',
            ),
        ),
        'api\\V1\\Rest\\EAConfiguration\\Validator' => array(
            0 => array(
                'name' => 'updatedAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            1 => array(
                'name' => 'createdAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            2 => array(
                'name' => 'title',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            3 => array(
                'name' => 'key_value',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            4 => array(
                'name' => 'value',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
            5 => array(
                'name' => 'editable',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
        ),
        'api\\V1\\Rest\\EAPrice\\Validator' => array(
            0 => array(
                'name' => 'updatedAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            1 => array(
                'name' => 'createdAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            2 => array(
                'name' => 'title',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            3 => array(
                'name' => 'price',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
            4 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'link_checkout',
            ),
            5 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'payment_method',
            ),
            6 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(),
                'name' => 'free',
            ),
        ),
        'api\\V1\\Rest\\ConfigurationMyfx\\Validator' => array(
            0 => array(
                'name' => 'updatedAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            1 => array(
                'name' => 'createdAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            2 => array(
                'name' => 'title',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            3 => array(
                'name' => 'key_value',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            4 => array(
                'name' => 'value',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
        ),
        'api\\V1\\Rest\\GraphPerformance\\Validator' => array(
            0 => array(
                'name' => 'updatedAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            1 => array(
                'name' => 'createdAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            2 => array(
                'name' => 'title',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                ),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            3 => array(
                'name' => 'account',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
            4 => array(
                'name' => 'active',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
        ),
        'api\\V1\\Rest\\EAYield\\Validator' => array(
            0 => array(
                'name' => 'updatedAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            1 => array(
                'name' => 'createdAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            2 => array(
                'name' => 'mes',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\Digits',
                    ),
                ),
                'validators' => array(),
            ),
            3 => array(
                'name' => 'ano',
                'required' => true,
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StripTags',
                    ),
                    1 => array(
                        'name' => 'Zend\\Filter\\Digits',
                    ),
                ),
                'validators' => array(),
            ),
            4 => array(
                'name' => 'percentual',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
            5 => array(
                'name' => 'fechado',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
        ),
        'api\\V1\\Rest\\EARequestPayment\\Validator' => array(
            0 => array(
                'name' => 'updatedAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            1 => array(
                'name' => 'createdAt',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            2 => array(
                'name' => 'value',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
            3 => array(
                'name' => 'paid_out',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            4 => array(
                'name' => 'date_payment',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            5 => array(
                'name' => 'due_date',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
        ),
    ),
);

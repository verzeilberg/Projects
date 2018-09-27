<?php

namespace Customers;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'controllers' => [
        'factories' => [
            Controller\CustomerController::class => Factory\CustomerControllerFactory::class,
            Controller\CountryController::class => Factory\CountryControllerFactory::class,
            Controller\ContactController::class => Factory\ContactControllerFactory::class
        ],
    ],
    'service_manager' => [
        'invokables' => [
            'Customers\Service\customerServiceInterface' => 'Customers\Service\customerService',
            'Customers\Service\countryServiceInterface' => 'Customers\Service\countryService',
            'Customers\Service\contactServiceInterface' => 'Customers\Service\contactService'
        ],
    ],
    // The following section is new and should be added to your file
    'router' => [
        'routes' => [
            'customers' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/customers[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\CustomerController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'countries' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/countries[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\CountryController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'contacts' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/contacts[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ContactController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'customers' => __DIR__ . '/../view',
        ],
    ],
    // The 'access_filter' key is used by the User module to restrict or permit
    // access to certain controller actions for unauthorized visitors.
    'access_filter' => [
        'controllers' => [
            \Customers\Controller\CustomerController::class => [
                // to anyone.
                ['actions' => '*', 'allow' => '+customer.manage']
            ],
            \Customers\Controller\CountryController::class => [
                // to anyone.
                ['actions' => '*', 'allow' => '+country.manage']
            ],
            \Customers\Controller\ContactController::class => [
                // to anyone.
                ['actions' => '*', 'allow' => '+contact.manage']
            ],
        ]
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entities']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entities' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
    'asset_manager' => [
        'resolver_configs' => [
            'paths' => [
                __DIR__ . '/../public',
            ],
        ],
    ],
];

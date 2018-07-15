<?php

namespace Customers;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'controllers' => [
        'factories' => [
            Controller\CustomersController::class => Factory\CustomersControllerFactory::class,
        ],
        'aliases' => [
            'customersbeheer' => Controller\CustomersController::class,
        ],
    ],
    'service_manager' => [
        'invokables' => [
            'Customers\Service\customersServiceInterface' => 'Customers\Service\customersService'
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
                        'controller' => 'customersbeheer',
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
            'customersbeheer' => [
                // to anyone.
                ['actions' => '*', 'allow' => '+customers.manage']
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
    ]
];

<?php

namespace Projects;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter;
use Gedmo\SoftDeleteable\SoftDeleteableListener;
use Gedmo\Timestampable\TimestampableListener;

return [
    'controllers' => [
        'factories' => [
            Controller\ProjectController::class => Factory\ProjectControllerFactory::class,
            Controller\ProjectTypeController::class => Factory\ProjectTypeControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'invokables' => [
            'Projects\Service\projectServiceInterface' => 'Projects\Service\projectService',
            'Projects\Service\projectTypeServiceInterface' => 'Projects\Service\projectTypeService',
        ],
    ],
    // The following section is new and should be added to your file
    'router' => [
        'routes' => [
            'projects' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/projects[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ProjectController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'projecttypes' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/project-types[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ProjectTypeController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'projects' => __DIR__ . '/../view',
        ],
    ],
    // The 'access_filter' key is used by the User module to restrict or permit
    // access to certain controller actions for unauthorized visitors.
    'access_filter' => [
        'controllers' => [
            \Projects\Controller\ProjectController::class => [
                // to anyone.
                ['actions' => '*', 'allow' => '+project.manage']
            ],
            \Projects\Controller\ProjectTypeController::class => [
                // to anyone.
                ['actions' => '*', 'allow' => '+project.type.manage']
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
        ],
        'eventmanager' => [
            'orm_default' => [
                'subscribers' => [
                    SoftDeleteableListener::class,
                    TimestampableListener::class,
                ],
            ],
        ],
        'configuration' => [
            'orm_default' => [
                'filters' => [
                    'soft-deletable' => SoftDeleteableFilter::class,
                ],
            ],
        ],
    ],
    'asset_manager' => [
        'resolver_configs' => [
            'paths' => [
                __DIR__ . '/../public',
            ],
        ],
    ],
];

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
            Controller\LevelController::class => Factory\LevelControllerFactory::class,
            Controller\ExpertiseController::class => Factory\ExpertiseControllerFactory::class,
            Controller\ConsultantController::class => Factory\ConsultantControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'invokables' => [
            'Projects\Service\projectServiceInterface' => 'Projects\Service\projectService',
            'Projects\Service\projectTypeServiceInterface' => 'Projects\Service\projectTypeService',
            'Projects\Service\levelServiceInterface' => 'Projects\Service\levelService',
            'Projects\Service\expertiseServiceInterface' => 'Projects\Service\expertiseService',
            'Projects\Service\consultantServiceInterface' => 'Projects\Service\consultantService',
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
            'levels' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/levels[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\LevelController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'expertises' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/expertises[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ExpertiseController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'consultants' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/consultants[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ConsultantController::class,
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
            \Projects\Controller\LevelController::class => [
                // to anyone.
                ['actions' => '*', 'allow' => '+level.manage']
            ],
            \Projects\Controller\ExpertiseController::class => [
                // to anyone.
                ['actions' => '*', 'allow' => '+expertise.manage']
            ],
            \Projects\Controller\ConsultantController::class => [
                // to anyone.
                ['actions' => '*', 'allow' => '+consultant.manage']
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

<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'application' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/application[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'about' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/about',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'about',
                    ],
                ],
            ],
            'beheer' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/beheer',
                    'defaults' => [
                        'controller' => Controller\BeheerController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'customers' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/customers[[/]:action[/:id]]',
                            'defaults' => [
                                'controller' => \Customers\Controller\CustomerController::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'languages' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/languages[[/]:action[/:id]]',
                            'defaults' => [
                                'controller' => \Translator\Controller\LanguageController::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'translators' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/translators[[/]:action[/:id]]',
                            'defaults' => [
                                'controller' => \Translator\Controller\TranslatorController::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'translations' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/translations[[/]:action[/:id]]',
                            'defaults' => [
                                'controller' => \Translator\Controller\TranslationController::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'contacts' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/contacts[[/]:action[/:id]]',
                            'defaults' => [
                                'controller' => \Customers\Controller\ContactController::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'projects' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/projects[[/]:action[/:id]]',
                            'defaults' => [
                                'controller' => \Projects\Controller\ProjectController::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'projecttypes' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/project-types[[/]:action[/:id]]',
                            'defaults' => [
                                'controller' => \Projects\Controller\ProjectTypeController::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'levels' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/levels[[/]:action[/:id]]',
                            'defaults' => [
                                'controller' => \Projects\Controller\LevelController::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'expertises' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/expertises[[/]:action[/:id]]',
                            'defaults' => [
                                'controller' => \Projects\Controller\ExpertiseController::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'consultants' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/consultants[[/]:action[/:id]]',
                            'defaults' => [
                                'controller' => \Projects\Controller\ConsultantController::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'images' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/images[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ],
                            'defaults' => [
                                'controller' => 'imagesbeheer',
                                'action' => 'index',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
        ],
    ],
    // The 'access_filter' key is used by the User module to restrict or permit
    // access to certain controller actions for unauthorized visitors.
    'access_filter' => [
        'options' => [
            // The access filter can work in 'restrictive' (recommended) or 'permissive'
            // mode. In restrictive mode all controller actions must be explicitly listed 
            // under the 'access_filter' config key, and access is denied to any not listed 
            // action for not logged in users. In permissive mode, if an action is not listed 
            // under the 'access_filter' key, access to it is permitted to anyone (even for 
            // not logged in users. Restrictive mode is more secure and recommended to use.
            'mode' => 'restrictive'
        ],
        'controllers' => [
            Controller\IndexController::class => [
                // Allow anyone to visit "index" and "about" actions
                ['actions' => ['index', 'about'], 'allow' => '*'],
                // Allow authorized users to visit "settings" action
                ['actions' => ['settings'], 'allow' => '@']
            ],
            \Customers\Controller\CustomerController::class => [
                // to anyone.
                ['actions' => '*', 'allow' => '+customer.manage']
            ],
            \Customers\Controller\ContactController::class => [
                // to anyone.
                ['actions' => '*', 'allow' => '+contact.manage']
            ],
            \Translator\Controller\LanguageController::class => [
                // to anyone.
                ['actions' => '*', 'allow' => '+language.manage']
            ],
            \Translator\Controller\TranslatorController::class => [
                // to anyone.
                ['actions' => '*', 'allow' => '+language.manage']
            ],
            \Translator\Controller\TranslationController::class => [
                // to anyone.
                ['actions' => '*', 'allow' => '+translation.manage']
            ],
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
    // This key stores configuration for RBAC manager.
    'rbac_manager' => [
        'assertions' => [Service\RbacAssertionManager::class],
    ],
    'service_manager' => [
        'factories' => [
            Service\NavManager::class => Service\Factory\NavManagerFactory::class,
            Service\RbacAssertionManager::class => Service\Factory\RbacAssertionManagerFactory::class,
        ],
    ],
    'view_helpers' => [
        'factories' => [
            View\Helper\Menu::class => View\Helper\Factory\MenuFactory::class,
            View\Helper\Breadcrumbs::class => InvokableFactory::class,
        ],
        'aliases' => [
            'mainMenu' => View\Helper\Menu::class,
            'pageBreadcrumbs' => View\Helper\Breadcrumbs::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    // The following key allows to define custom styling for FlashMessenger view helper.
    'view_helper_config' => [
        'flashmessenger' => [
            'message_open_format' => '<div%s><ul><li>',
            'message_close_string' => '</li></ul></div>',
            'message_separator_string' => '</li><li>'
        ]
    ],
];

<?php

namespace Blog;

use Blog\Controller\DeleteController;
use Blog\Controller\ListController;
use Blog\Controller\WriteController;
use Blog\Factory\DeleteControllerFactory;
use Blog\Factory\ListControllerFactory;
use Blog\Factory\WriteControllerFactory;
use Blog\Factory\ZendDbSqlCommandFactory;
use Blog\Factory\ZendDbSqlRepositoryFactory;
use Blog\Model\PostCommand;
use Blog\Model\PostCommandInterface;
use Blog\Model\PostRepository;
use Blog\Model\PostRepositoryInterface;
use Blog\Model\ZendDbSqlCommand;
use Blog\Model\ZendDbSqlRepository;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            ListController::class => ListControllerFactory::class,
            WriteController::class => WriteControllerFactory::class,
            DeleteController::class => DeleteControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'aliases' => [
            PostRepositoryInterface::class => ZendDbSqlRepository::class,
            PostCommandInterface::class => ZendDbSqlCommand::class,
        ],
        'factories' => [
            PostRepository::class => InvokableFactory::class,
            ZendDbSqlRepository::class => ZendDbSqlRepositoryFactory::class,
            PostCommand::class => InvokableFactory::class,
            ZendDbSqlCommand::class => ZendDbSqlCommandFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'blog' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/blog',
                    'defaults' => [
                        'controller' => ListController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'detail' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/:id',
                            'defaults' => [
                                'action' => 'detail',
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*',
                            ],
                        ],
                    ],
                    'add' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/add',
                            'defaults' => [
                                'controller' => WriteController::class,
                                'action' => 'add',
                            ],
                        ],
                    ],
                    'edit' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/edit/:id',
                            'defaults' => [
                                'controller' => WriteController::class,
                                'action' => 'edit',
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*',
                            ],
                        ],
                    ],
                    'delete' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/delete/:id',
                            'defaults' => [
                                'controller' => DeleteController::class,
                                'action' => 'delete',
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
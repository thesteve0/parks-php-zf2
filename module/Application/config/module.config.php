<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

$mongodb = new Mongo("mongodb://" . 
    getenv('OPENSHIFT_NOSQL_DB_USERNAME') . ":" . 
    getenv('OPENSHIFT_NOSQL_DB_PASSWORD') . "@" . 
    getenv('OPENSHIFT_NOSQL_DB_HOST') . ":" . 
    getenv('OPENSHIFT_NOSQL_DB_PORT'));

$mongodb_name = getenv('OPENSHIFT_APP_NAME');

$GLOBALS['mongodb'] = $mongodb->{$mongodb_name};

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'parks' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/ws/parks',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'parks',
                    ),
                ),
            ),
            'park' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/ws/parks/park/:park',
                    'constraints' => array(
                        'park' => '[a-zA-Z0-9_-]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'park',
                        'park'       => null
                    ),
                ),
            ),
            'near' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/ws/parks/near',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'near',
                    ),
                ),
            ),
            'namedNear' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/ws/parks/name/near/:name',
                    'constraints' => array(
                        'name' => '[a-zA-Z0-9_-]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'namedNear',
                        'name'       => null
                    ),
                ),
            ),
            'test' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/test',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'test',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
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
            'Application\Controller\Index' => 'Application\Controller\IndexController'
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
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    )
);

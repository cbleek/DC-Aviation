<?php


\Aviation\Module::$isLoaded = true;

/**
 * create a config/autoload/Aviation.global.php and put modifications there
 */

return array(
    'service_manager' => [
        'factories' => [
            'Auth/Dependency/Manager' => 'Aviation\Factory\Dependency\ManagerFactory',
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout.phtml',
            'layout/application-form' => __DIR__ . '/../view/application-form.phtml',
            'core/index/index' => __DIR__ . '/../view/index.phtml',
            'piwik' => __DIR__ . '/../view/piwik.phtml',
            'jobs/jobboard/index.ajax.phtml' => __DIR__ . '/../view/jobs/index.ajax.phtml',
            'templates/default/index' => __DIR__ . '/../view/jobs/templates/index.phtml',
            'iframe/iFrame.phtml' => __DIR__ . '/../view/jobs/iFrame.phtml',
            ],
        ],
        'translator' => array(
            'translation_file_patterns' => array(
                array(
                    'type' => 'gettext',
                    'base_dir' => __DIR__ . '/../language',
                    'pattern' => '%s.mo',
                    ),
                ),
        ),
        'form_elements' => [
            'invokables' => [
                'Jobs/Description' => 'Aviation\Form\JobsDescription',
            ],
        ],

);

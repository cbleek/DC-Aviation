<?php

declare(strict_types=1);

namespace Aviation;

use Aviation\Listener\AutoAcceptTermsOfServiceListener;
use Aviation\Queue\ApplicationConfirmMailJob;
use Jobs\Listener\Events\JobEvent;
use Laminas\ServiceManager\Factory\InvokableFactory;

\Aviation\Module::$isLoaded = true;

/**
 * create a config/autoload/Aviation.global.php and put modifications there
 */

return array(

    'doctrine' => [
        'eventmanager' => [
            'odm_default' => [
                'subscribers' => [
                    AutoAcceptTermsOfServiceListener::class,
                ],
            ],
        ],
    ],

    'navigation' => [
        'default' => [
            'dashboard' => [
                'visible' => false
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'Auth/Dependency/Manager' => 'Aviation\Factory\Dependency\ManagerFactory',
            Listener\AutoJobActivation::class => Listener\AutoJobActivationFactory::class,
            Entity\ApplicationStatusMailTemplates::class => Entity\ApplicationStatusMailTemplatesFactory::class,
            Listener\ApplicationCreated::class => Listener\ApplicationCreatedFactory::class,
        ],
        'delegators' => [
            'Applications/Listener/ApplicationStatusChangePre' => [
                Listener\ApplicationStatusChangeDelegatorFactory::class,
            ],
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout.phtml',
            'layout/application-form' => __DIR__ . '/../view/application-form.phtml',
            'aviation/footer' => __DIR__ . '/../view/footer.phtml',
            'core/index/index' => __DIR__ . '/../view/index.phtml',
            'piwik' => __DIR__ . '/../view/piwik.phtml',
            'jobs/jobboard/index.ajax.phtml' => __DIR__ . '/../view/jobs/index.ajax.phtml',
            'jobs/index/index.ajax.phtml' => __DIR__ . '/../view/jobs/manage.ajax.phtml',
            'templates/default/index' => __DIR__ . '/../view/jobs/templates/index.phtml',
            'iframe/iFrame.phtml' => __DIR__ . '/../view/jobs/iFrame.phtml',
            'jobs/form/preview' => __DIR__ . '/../view/jobs/preview.phtml',
            'applications/apply/_buttons' => __DIR__ . '/../view/applications/_buttons.phtml',
        ],
    ],
    'view_helpers' => [
        'factories' => [
            View\Helper\FormatLocation::class => InvokableFactory::class
        ],
        'aliases' => [
            'formatLocation' => View\Helper\FormatLocation::class,
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

    'validators' => [
        'invokables' => [
            'Applications/Application' => Validator\ApplicationValidator::class,
        ],
    ],

    'event_manager' => [
        'Jobs/JobContainer/Events' => ['listeners' => [
            Listener\JobContainerInitListener::class => [\Core\Form\Event\FormEvent::EVENT_INIT, true]
        ]],

        'Jobs/Events' => ['listeners' => [
            Listener\AutoJobActivation::class => [
                'events' => [
                    JobEvent::EVENT_JOB_CREATED => 'activateCreatedJob',
                    JobEvent::EVENT_STATUS_CHANGED => 'activateChangedJob'
                ],
                'lazy' => true,
            ],
        ]],


        'Applications/Events' => [ 'listeners' => [
            Listener\ApplicationCreated::class => [
                \Applications\Listener\Events\ApplicationEvent::EVENT_APPLICATION_POST_CREATE,
                true
            ],
        ]],
    ],

);

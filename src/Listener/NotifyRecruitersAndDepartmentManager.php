<?php

/**
 * Aviation
 *
 * @copyright 2020-2021 Cross Solution <http://cross-solution.de>
 * @license   MIT
 */

declare(strict_types=1);

namespace Aviation\Listener;

use Applications\Listener\Events\ApplicationEvent;
use Core\Mail\MailService;
use Organizations\Entity\EmployeeInterface;

/**
 * TODO: description
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
class NotifyRecruitersAndDepartmentManager
{
    private $mails;

    public function __construct(MailService $mails)
    {
        $this->mails = $mails;
    }

    public function __invoke(ApplicationEvent $event)
    {
        $application = $event->getApplicationEntity();
        $job = $application->getJob();
        $org = $job->getOrganization()->getParent(/*returnSelf*/ true);
        $admin = $org->getUser();
        $adminSettings = $admin->getSettings('Applications');

        $assignedManagers = $job->getMetaData('organizations:managers', []);
        if (count($assignedManagers)) {
            $managers = [];
            foreach ($assignedManagers as $manager) {
                $manager = $org->getEmployee($manager['id']);
                if ($manager) {
                    $managers[] = $manager;
                }
            }
        } else {
            $managers = $org->getEmployeesByRole(EmployeeInterface::ROLE_DEPARTMENT_MANAGER);
        }

        if (count($managers)) {
            foreach ($managers as $employee) {
                /* @var EmployeeInterface $employee */
                $managerMail = $this->mails->build(
                    'Applications/NewApplication',
                    [
                        'application' => $application,
                        'user' => $employee->getUser(),
                        'bcc' => $adminSettings->getMailBCC() ? [ $admin ] : null,
                    ]
                );
                $managerMail->setBody("Hallo ##name##,\n\nes gibt eine neue Bewerbung für die Anzeige: \n\"##title##\"\n\n##link##\n\n");
                $this->mails->send($managerMail);
            }
        }

        $mail = $this->mails->build(
            'Applications/NewApplication',
            [
                'application' => $application,
                'user' => $job->getUser(),
                'bcc' => $adminSettings->getMailBCC() ? [$admin] : null,
            ]
        );
        $mail->setTo('career@dc-aviation.com');
        $mail->setBody("Hallo,\n\nes gibt eine neue Bewerbung für die Anzeige: \n\n\"##title##\"\n\n##link##\n\n");

        $this->mails->send($mail);
    }
}

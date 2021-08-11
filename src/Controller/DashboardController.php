<?php

/**
 * Aviation
 *
 * @copyright 2020-2021 Cross Solution <http://cross-solution.de>
 * @license   MIT
 */

declare(strict_types=1);

namespace Aviation\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

/**
 * TODO: description
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
class DashboardController extends AbstractActionController
{

    public function jobsAction()
    {
        $paginator = $this->paginator('Jobs/Job', $this->params()->fromRoute());

        $model = new ViewModel([
            'type'   => $this->params('type'),
            'myJobs' => $this->jobRepository,
            'jobs'   => $paginator
        ]);
        $model->setTemplate('jobs/index/dashboard');

        return $model;
    }
}

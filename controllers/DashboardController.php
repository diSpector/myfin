<?php

namespace app\controllers;

use app\base\BaseController;
use app\controllers\actions\dashboard\ViewDashboardAction;
use app\controllers\actions\dashboard\UpdateDashboardAction;
use app\controllers\actions\dashboard\ViewTestDashboardAction;

class DashboardController extends BaseController
{
    public function actions()
    {
        return [
            'view' => ViewDashboardAction::class,
            'update' => UpdateDashboardAction::class,
            'view_test' => ViewTestDashboardAction::class,
        ];
    }
}
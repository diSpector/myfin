<?php

namespace app\controllers;

use app\base\BaseController;
use app\controllers\actions\dashboard\ViewDashboardAction;
use app\controllers\actions\dashboard\UpdateDashboardAction;

class DashboardController extends BaseController
{
    public function actions()
    {
        return [
            'view' => ViewDashboardAction::class,
            'update' => UpdateDashboardAction::class,
            
        ];
    }
}
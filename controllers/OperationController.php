<?php

namespace app\controllers;

use app\base\BaseController;
use app\controllers\actions\operation\ViewOperationAction;
use app\controllers\actions\operation\CreateOperationAction;
use app\controllers\actions\operation\DeleteOperationAction;
use app\controllers\actions\operation\UpdateOperationAction;
use app\controllers\actions\operation\ViewOperationTestAction;
use app\controllers\actions\operation\CreateOperationTestAction;


class OperationController extends BaseController
{
    public function actions()
    {
        return [
            // 'create' => CreateOperationAction::class,
            'create' => CreateOperationTestAction::class,
            // 'view' => ViewOperationAction::class,
            'view' => ViewOperationTestAction::class,
            'update' => UpdateOperationAction::class,
            // 'delete' => DeleteOperationAction::class,
        ];
    }
}
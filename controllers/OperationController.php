<?php

namespace app\controllers;

use app\base\BaseController;
use app\controllers\actions\operation\ViewOperationAction;
use app\controllers\actions\operation\IndexOperationAction;
use app\controllers\actions\operation\CreateOperationAction;
use app\controllers\actions\operation\DeleteOperationAction;
use app\controllers\actions\operation\UpdateOperationAction;
use app\controllers\actions\ajax\AjaxOperationValidationAction;
use app\controllers\actions\operation\CreateTestOperationAction;


class OperationController extends BaseController
{
    public function actions()
    {
        return [
            'view' => ViewOperationAction::class,
            'update' => UpdateOperationAction::class,
            // 'create' => CreateOperationAction::class, // работающий экшен БЕЗ перекидывания между счетами
            'create_test' => CreateTestOperationAction::class, // тестовый экшен с добавлением фичи перекидывания денег между счетами 
            'index' => IndexOperationAction::class,
            'validate' => AjaxOperationValidationAction::class,
        ];
    }
}
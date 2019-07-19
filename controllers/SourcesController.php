<?php

namespace app\controllers;

use app\base\BaseController;
use app\controllers\actions\sources\CreateSourceAction;
use app\controllers\actions\sources\ViewSourceAction;
use app\controllers\actions\sources\UpdateSourceAction;
use app\controllers\actions\sources\DeleteSourceAction;


class SourcesController extends BaseController
{
    public function actions()
    {
        return [
            'create' => CreateSourceAction::class,
            'view' => ViewSourceAction::class,
            'update' => UpdateSourceAction::class,
            'delete' => DeleteSourceAction::class,
        ];
    }
}
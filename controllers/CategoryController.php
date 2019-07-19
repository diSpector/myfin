<?php

namespace app\controllers;

use app\base\BaseController;
use app\controllers\actions\category\ViewCategoryAction;
use app\controllers\actions\category\CreateCategoryAction;
use app\controllers\actions\category\DeleteCategoryAction;
use app\controllers\actions\category\UpdateCategoryAction;

class CategoryController extends BaseController
{
    public function actions()
    {
        return [
            'create' => CreateCategoryAction::class,
            'view' => ViewCategoryAction::class,
            'update' => UpdateCategoryAction::class,
            'delete' => DeleteCategoryAction::class,
        ];
    }
}
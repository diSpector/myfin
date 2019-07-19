<?php

namespace app\controllers;
use yii\web\Controller;
use app\controllers\actions\GenAction;

class RbacController extends Controller
{
    public function actions()
    {
        return [
            'gen' => [
                'class' => GenAction::class
            ],
        ];
    }
}
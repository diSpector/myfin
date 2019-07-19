<?php

namespace app\controllers;

use yii\web\Controller;
use app\controllers\actions\auth\LogoutAction;
use app\controllers\actions\auth\SignInAction;
use app\controllers\actions\auth\SignUpAction;

class AuthController extends Controller
{
    public function actions()
    {
        return [
            'sign-in' => SignInAction::class,
            'sign-up' => SignUpAction::class,
            'logout' => LogoutAction::class,
        ];
    }
}
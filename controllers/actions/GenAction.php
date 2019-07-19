<?php

namespace app\controllers\actions;

use yii\base\Action;

class GenAction extends Action
{
    public function run()
    {
        $comp = \Yii::$app->rbac->generateRbacRules();
    }
}
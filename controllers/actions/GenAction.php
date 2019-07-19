<?php

namespace app\controllers\actions;

use app\components\RbacComponent;
use yii\base\Action;

class GenAction extends Action
{
    public function run()
    {
        /** @var RbacComponent $comp */
        $comp = \Yii::$app->rbac->generateRbacRules();
    }
}
<?php

namespace app\controllers\actions\ajax;

use Yii;
use yii\base\Action;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\components\DateRangeFormComponent;

class AjaxOperationValidationAction extends Action
{
    public function run()
    {
        /** @var DateRangeFormComponent $comp */
        $comp = Yii::$app->dateRangeForm;
        $model = $comp->getModel();
        $request = \Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }
}

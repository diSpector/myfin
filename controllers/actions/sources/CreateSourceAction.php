<?php

namespace app\controllers\actions\sources;

use Yii;
use yii\base\Action;
use app\models\SourcesForm;

class CreateSourceAction extends Action
{
    public function run()
    {

        $comp = Yii::$app->sources;
        $model = $comp->getModel();
        $types = Yii::$app->operationType->getModel();

        if ($model->load(Yii::$app->request->post())) {
            if ($comp->createNewSource($model)) {
                Yii::$app->session->setFlash('success', 'Добавлен новый источник - ' . $model->name);
                return $this->controller->redirect('/sources/view');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка. Добавление нового источника не удалось');
            }
        }

        return $this->controller->render('create', [
            'model' => $model,
            'types' => $types,
        ]);
    }
}

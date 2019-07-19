<?php

namespace app\controllers\actions\sources;

use Yii;
use yii\base\Action;
use yii\web\HttpException;

class UpdateSourceAction extends Action
{
    public function run($id)
    {
        $comp = Yii::$app->sources;
        $model = $comp->getSourceById($id);
        $types = Yii::$app->operationType->getModel();

        if (!\Yii::$app->rbac->canEditCategory($model) && !\Yii::$app->rbac->canViewEditAll()) {
            throw new HttpException(403, 'У вас нет прав на редактирование этого источника');
        }

        if ($model->load(Yii::$app->request->post())) {
            if (!$comp->updateSource($model)) {
                Yii::$app->session->setFlash('error', 'Ошибка. Не удалось обновить источник');
            } else {
                Yii::$app->session->setFlash('success', 'Источник успешно обновлен');
                return $this->controller->redirect('/sources/view');
            }
        }

        return $this->controller->render('update', [
            'model' => $model,
            'types' => $types
            ]);
    }
}

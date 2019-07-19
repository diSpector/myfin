<?php

namespace app\controllers\actions\sources;

use Yii;
use yii\base\Action;

class DeleteSourceAction extends Action
{
    public function run()
    {
        $comp = Yii::$app->sources;

        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('id');
            $model = $comp->getSourceById($id);

            if (!\Yii::$app->rbac->canEditCategory($model) && !\Yii::$app->rbac->canViewEditAll()) {
                throw new HttpException(403, 'У вас нет прав на удаление этого источника');
            }

            if (!$comp->deleteSource($model)) {
                Yii::$app->session->setFlash('error', 'Ошибка. Не удалось удалить источник');
            } else {
                Yii::$app->session->setFlash('success', 'Источник успешно удален');
            }
            return $this->controller->redirect('/sources/view');

        } else {

            return $this->controller->redirect('/sources/view');
        }
    }
}

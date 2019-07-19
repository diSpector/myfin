<?php

namespace app\controllers\actions\operation;

use Yii;
use yii\base\Action;

class DeleteOperationAction extends Action
{
    public function run()
    {
        $comp = Yii::$app->operation;

        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('id');
            $model = $comp->getOperationById($id);

            if (!\Yii::$app->rbac->canEditCategory($model) && !\Yii::$app->rbac->canViewEditAll()) {
                throw new HttpException(403, 'У вас нет прав на удаление этой операции');
            }

            if (!$comp->deleteOperation($model)) {
                Yii::$app->session->setFlash('error', 'Ошибка. Не удалось удалить операцию');
                return $this->controller->redirect('/operation/view');
            } else {
                Yii::$app->session->setFlash('success', 'Операция успешно удалена');
                return $this->controller->redirect('/operation/view');
            }
        }

        return $this->controller->redirect('/operation/view');
    }
}

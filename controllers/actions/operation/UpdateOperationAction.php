<?php

namespace app\controllers\actions\operation;

use Yii;
use yii\base\Action;
use yii\web\HttpException;
use app\components\OperationComponent;

class UpdateOperationAction extends Action
{
    public function run($id)
    {
        /** @var OperationComponent $comp */
        $comp = Yii::$app->operation;
        $userId = Yii::$app->user->id;
        $model = $comp->getOperationById($id);
        $types = $comp->getOperationTypes();
        $categories = $comp->getUserCategories($userId, ['id' => $model->type]);
        $sources = $comp->getUserSources($userId);

        if (!\Yii::$app->rbac->canEditCategory($model) && !\Yii::$app->rbac->canViewEditAll()) {
            throw new HttpException(403, 'У вас нет прав на редактирование этой операции');
        }

        if ($model->load(Yii::$app->request->post())) {

            $button = Yii::$app->request->post('button');
            if ($button === 'delete') {
                if (!$comp->deleteOperation($model)) {
                    Yii::$app->session->setFlash('error', 'Ошибка. Не удалось удалить операцию');
                }
                Yii::$app->session->setFlash('success', 'Операция успешно удалена');
                return $this->controller->redirect('/operation/view');
            }

            if (!$comp->updateOperation($model)) {
                if (!$model->validate('date_picked')) {
                    $model->date_picked = date('Y-m-d');
                }
                Yii::$app->session->setFlash('error', 'Ошибка. Не удалось обновить операцию');
            } else {
                Yii::$app->session->setFlash('success', 'Операция успешно обновлена');
                return $this->controller->redirect('/operation/view');
            }
        }

        return $this->controller->render('update', [
            'model' => $model,
            'types' => $types,
            'sources' => $sources,
            'categories' => $categories,
        ]);
    }
}

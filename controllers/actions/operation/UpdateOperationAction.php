<?php

namespace app\controllers\actions\operation;

use Yii;
use yii\base\Action;
use yii\web\HttpException;

class UpdateOperationAction extends Action
{
    public function run($id)
    {
        $comp = Yii::$app->operation;
        $userId = Yii::$app->user->id;
        $model = $comp->getOperationById($id);
        $types = $comp->getOperationTypes();
        $categories = $comp->getUserCategories($userId, ['id' => $model->type]);
        $sources = $comp->getUserSources($userId);

        if (!\Yii::$app->rbac->canEditCategory($model) && !\Yii::$app->rbac->canViewEditAll()) {
            throw new HttpException(403, 'У вас нет прав на редактирование этой категории');
        }

        if ($model->load(Yii::$app->request->post())) {
            if (!$comp->updateOperation($model)) {
                if(!$model->validate('date_picked')){
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

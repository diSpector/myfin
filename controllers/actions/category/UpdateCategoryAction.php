<?php

namespace app\controllers\actions\category;

use Yii;
use yii\base\Action;
use yii\web\HttpException;

class UpdateCategoryAction extends Action
{
    public function run($id)
    {
        $comp = Yii::$app->category;
        $model = $comp->getCategoryById($id);
        $types = $comp->getOperationTypes();

        if (!\Yii::$app->rbac->canEditCategory($model) && !\Yii::$app->rbac->canViewEditAll()) {
            throw new HttpException(403, 'У вас нет прав на редактирование этой категории');
        }

        if ($model->load(Yii::$app->request->post())) {
            if (!$comp->updateCategory($model)) {
                Yii::$app->session->setFlash('error', 'Ошибка. Не удалось обновить категорию');
            } else {
                Yii::$app->session->setFlash('success', 'Категория успешно обновлена');
                return $this->controller->redirect('/category/view');
            }
        }

        return $this->controller->render('update', [
            'model' => $model,
            'types' => $types
        ]);
    }
}

<?php

namespace app\controllers\actions\category;

use Yii;
use yii\base\Action;

class DeleteCategoryAction extends Action
{
    public function run()
    {
        $comp = Yii::$app->category;

        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('id');
            $model = $comp->getCategoryById($id);

            if (!\Yii::$app->rbac->canEditCategory($model) && !\Yii::$app->rbac->canViewEditAll()) {
                throw new HttpException(403, 'У вас нет прав на удаление этой категории');
            }

            if (!$comp->deleteCategory($model)) {
                Yii::$app->session->setFlash('error', 'Ошибка. Не удалось удалить категорию');
                return $this->controller->redirect('/category/view');
            } else {
                Yii::$app->session->setFlash('success', 'Категория успешно удалена');
                return $this->controller->redirect('/category/view');
            }
        }

        return $this->controller->redirect('/category/view');
    }
}

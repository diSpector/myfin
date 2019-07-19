<?php

namespace app\controllers\actions\category;

use Yii;
use yii\base\Action;

class CreateCategoryAction extends Action
{
    public function run()
    {
        $comp = Yii::$app->category;
        $model = $comp->getModel();

        $userId = Yii::$app->user->id;
        $categories = $comp->getSearchProvider($userId, Yii::$app->request->get());

        $types = $comp->getOperationTypes();

        $defaultCategories = $comp->getDefaultCategories();

        if ($model->load(Yii::$app->request->post())) {
            if ($comp->createNewCategory($model)) {
                Yii::$app->session->setFlash('success', 'Добавлена новая категория - ' . $model->name);
                return $this->controller->redirect('view');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка. Добавление новой категории не удалось');
            }
        }

        return $this->controller->render('create', [
            'model' => $model,
            'dataProvider' => $categories,
            'default_categories' => $defaultCategories,
            'types' => $types,
        ]);
    }
}

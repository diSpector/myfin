<?php

namespace app\controllers\actions\category;

use app\components\CategoryComponent;
use Yii;
use yii\base\Action;

class ViewCategoryAction extends Action
{
    public function run()
    {
      /** @var CategoryComponent $comp */
        $comp = Yii::$app->category;
        $userId = Yii::$app->user->id;
        $filterModel = $comp->getCategorySearch();
        $categories = $comp->getSearchProvider($userId, Yii::$app->request->get());

        return $this->controller->render('view', [
            'dataProvider' => $categories,
            'filterModel' => $filterModel,
        ]);
    }
}

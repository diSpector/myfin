<?php

namespace app\components;

use Yii;
use yii\base\Component;
use app\models\Category;
use yii\helpers\ArrayHelper;
use app\models\OperationForm;
use app\models\OperationType;
use app\models\DefaultCategory;
use app\components\dataproviders\CategorySearch;

class CategoryComponent extends Component
{
    public function getModel($params = null)
    {
        $model = new Category($params);

        return $model;
    }

    public function createNewCategory(&$model)
    {
        $model->user_id = Yii::$app->user->id;

        if (!$model->save()) {
            return false;
        }

        return true;
    }

    public function updateCategory(&$model)
    {
        if (!$model->update()) {
            return false;
        }

        return true;
    }

    public function deleteCategory(&$model)
    {
        if (!$model->delete()) {
            return false;
        }

        return true;
    }

    public function getCategoryById($id)
    {
        return $this->getModel()::find()->where(['id' => $id])->one();
    }

    public function getSearchProvider($user_id, $params)
    {
        $model = new CategorySearch();
        // return $model->getDataProvider($params);
        return $model->search($user_id, $params);

    }

    public function getCategorySearch(){
        return new CategorySearch();
    }

    public function getDefaultCategories()
    {
        return DefaultCategory::find()->all();
    }

    public function getOperationTypes()
    {
        return ArrayHelper::map(OperationForm::find()->all(), 'id', 'name');

    }
}

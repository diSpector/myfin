<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use app\models\OperationForm;
use app\models\OperationType;
use app\models\DefaultCategory;
use app\models\Operation;
use app\components\dataproviders\OperationSearch;
use app\models\Category;
use app\models\Sources;
use app\models\Users;

class OperationComponent extends Component
{
  public function getModel($params = null)
  {
    $model = new Operation($params);

    return $model;
  }

  public function createNewOperation(&$model)
  {
    $model->user_id = Yii::$app->user->id;

    if (!$model->save()) {
      return false;
    }

    return true;
  }

  public function updateOperation(&$model)
  {
    if (!$model->update()) {
      return false;
    }

    return true;
  }

  public function deleteOperation(&$model)
  {
    if (!$model->delete()) {
      return false;
    }

    return true;
  }

  public function getOperationById($id)
  {
    return $this->getModel()::find()->where(['id' => $id])->one();
  }

  public function getSearchProvider($user_id, $params)
  {
    $model = new OperationSearch();
    return $model->search($user_id, $params);
  }

  public function getOperationSearch()
  {
    return new OperationSearch();
  }

  public function getUserCategories($userId, $params = [])
  {
    // return Category::find()->where(['user_id' => $userId])->all();
    return ArrayHelper::map(Category::find()->where(['user_id' => $userId])->andFilterWhere(['type' => $params['id']])->all(), 'id', 'name');
  }

  public function getUserSources($userId)
  {
    return ArrayHelper::map(Sources::find()->where(['user_id' => $userId])->all(), 'id', 'name');
  }

  // public function getDefaultCategories()
  // {
  //     return DefaultCategory::find()->all();
  // }

  // получить все типы операций (расход, доход)
  public function getOperationTypes()
  {
    return ArrayHelper::map(OperationForm::find()->all(), 'id', 'name');
  }

  // получить типы операций, доступные для этого пользователя
  public function getOperationTypesForUser($userId)
  {
    /** @var Query $query */
    $query = ArrayHelper::map((new \yii\db\Query())
        ->select(['operation_form.id', 'operation_form.name'])
        ->from('category')
        ->join('inner join', 'operation_form', 'category.type = operation_form.id')
        ->groupBy('category.type')
        ->where(['user_id' => $userId])
        ->all(), 'id', 'name');

    return $query;
  }
}

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

    public function getAllDatesPicked($userId)
    {
        // return ArrayHelper::index(Operation::find()->select(['category_id', 'source_id', 'sum', 'name', 'date_picked'])->distinct()->where(['user_id' => $userId])->all(), 'date_picked');
        return ArrayHelper::getColumn(Operation::find()->select(['date_picked'])->distinct()->where(['user_id' => $userId])->asArray()->all(), 'date_picked');
        // return Operation::find()->where(['user_id' => $userId])->asArray()->all();
        // var_dump(Operation::find()->where(['user_id' => $userId])->asArray()->all());
        // return ArrayHelper::index(ArrayHelper::map(Operation::find()->select(['id', 'date_picked'])->where(['user_id' => $userId])->all(), 'id', 'date_picked'), 'date_picked');
        // return ArrayHelper::index(ArrayHelper::map(Operation::find()->select(['id', 'date_picked'])->where(['user_id' => $userId])->all(), 'date_picked', 'id'), null, 'date_picked');

    }

    public function getOperationsByDate($date)
    {
        return Operation::find()->where(['date_picked' => $date])->asArray()->all();
    }

    public function getAllOperationsForUser($userId)
    {
        // рабочий
        // return ArrayHelper::index(Operation::find()->where(['user_id' => $userId])->asArray()->all(), null, 'date_picked');
        
        return ArrayHelper::index(Operation::find()
        ->select(['operations.id id', 'operations.name name', 'operations.sum sum', 'operations.type type', 'operations.date_picked', 'c.name cname', 's.name sname'])
        ->where(['operations.user_id' => $userId])
        ->joinWith('category as c')
        ->joinWith('source as s')
        ->orderBy('date_picked')
        ->asArray()->all(), null, 'date_picked');
        
        // $result =  ArrayHelper::index(Operation::find()
        //     ->select(['operations.id', 'operations.name', 'operations.date_picked', 'category.name', 'sources.name'])
        //     ->join('inner join', 'category', 'operations.category_id = category.id')
        //     ->join('inner join','sources', 'operations.source_id = sources.id')
        //     // ->joinWith('source')
        //     ->where(['operations.user_id' => $userId])->asArray()->all(), null, 'operations.date_picked');

    }
}

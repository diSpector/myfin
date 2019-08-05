<?php

namespace app\components;

use Yii;
use yii\db\Query;
use app\models\Users;
use yii\db\Expression;
use app\models\Sources;
use yii\base\Component;
use app\models\Category;
use app\models\Operation;
use yii\helpers\ArrayHelper;
use app\models\OperationForm;
use app\models\OperationType;
use app\models\DefaultCategory;
use app\components\dataproviders\OperationSearch;

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

    // используется в старом экшене ViewOperationAction, можно удалить
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

    public function getAllOperationsForUser($userId, $startDate, $stopDate)
    {
        // вернуть все операции пользователя за последние 30 дней в виде массива с ключами-датами
        return ArrayHelper::index(
            Operation::find()
                ->select(['operations.id id', 'operations.name name', 'operations.sum sum', 'operations.type type', 'operations.date_picked', 'c.name cname', 's.name sname'])
                ->where(['operations.user_id' => $userId])
                // ->andWhere(['>', 'date_picked', new Expression('CURRENT_DATE() - INTERVAL 1 MONTH')])
                ->andWhere(['>', 'date_picked', $startDate])
                ->andWhere(['<=', 'date_picked', $stopDate])
                ->joinWith('category c')
                ->joinWith('source s')
                ->orderBy('date_picked desc')
                ->asArray()
                ->all(),
            null,
            'date_picked'
        );
    }

    // public function getLastOperations($userId, $stopDate, $count = 10)
    // {
    //     return ArrayHelper::index(
    //         Operation::find()
    //             ->select(['operations.id id', 'operations.name name', 'operations.sum sum', 'operations.type type', 'operations.date_picked', 'c.name cname', 's.name sname'])
    //             ->where(['operations.user_id' => $userId])
    //             ->andWhere(['<=', 'date_picked', $stopDate])
    //             ->joinWith('category c')
    //             ->joinWith('source s')
    //             ->orderBy('date_picked desc')
    //             ->limit($count)
    //             ->asArray()
    //             ->all(),
    //         null,
    //         'date_picked'
    //     );
    // }

    public function getLastOperations($userId, $from, $count = 10)
    {
        return ArrayHelper::index(
            Operation::find()
                ->select(['operations.id id', 'operations.name name', 'operations.sum sum', 'operations.type type', 'operations.date_picked', 'c.name cname', 's.name sname'])
                ->where(['operations.user_id' => $userId])
                // ->andWhere(['<=', 'date_picked', $stopDate])
                ->joinWith('category c')
                ->joinWith('source s')
                ->orderBy('date_picked desc')
                ->limit($count)
                ->offset($from)
                ->asArray()
                ->all(),
            null,
            'date_picked'
        );
    }

    // получить $count последних операций пользователя, начиная с $from 
    public function getOperations($userId, $from = '', $count = '')
    {
        return
            Operation::find()
            ->select(['operations.id id', 'operations.name name', 'operations.sum sum', 'operations.type type', 'operations.date_picked', 'c.name cname', 's.name sname'])
            ->where(['operations.user_id' => $userId])
            ->joinWith('category c')
            ->joinWith('source s')
            ->orderBy('date_picked desc')
            ->limit($count)
            ->offset($from)
            ->asArray()
            ->all();
    }

    // посчитать количество операций
    public function howManyOperations($arr)
    {
        return count($arr);
    }

    // переиндексировать массив операций по числам - 'число1' => ['операция 1' => 'данные операции 1', ...], ...
    public function reIndexOperations($arr)
    {
        return ArrayHelper::index($arr, null, 'date_picked');
    }

    // посчитать текущий баланс по всем источникам
    public function getTotalBalance($userId){
        // SELECT sum(CASE when type=1 THEN -sum else sum end) FROM `operations` where `user_id`=15
        // return Operation::find()
        // ->select('sum(CASE when type=1 THEN -sum else sum end) balance')
        // ->andWhere(['user_id' => $userId])
        // ->groupBy('source_id')
        // ->asArray()
        // ->one();

        // SELECT source_id, sum(CASE when type=1 THEN -sum else sum end) FROM `operations` where user_id=15 GROUP BY `source_id`

        // если по источникам не было операций, сейчас баланс по ним не выводится. TODO - сделать, чтобы выводился баланс по ВСЕМ операциям
        // SELECT o.source_id, (total + sum(CASE when o.type=1 THEN -sum else sum end)) afterinit, total FROM operations o INNER JOIN sources s on o.source_id = s.id where o.user_id=17 GROUP BY `source_id`
        return Operation::find()
        ->select(['operations.source_id', 's.name', 'sum(CASE when operations.type=1 THEN -sum else sum end) sum', 's.total'])
        ->where(['operations.user_id' => $userId])
        ->joinWith('source s')
        ->groupBy('source_id')
        ->asArray()
        ->all();
    }
}

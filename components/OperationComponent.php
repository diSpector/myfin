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

        switch ($model->type){
            case '3': // если 3, то сохранить как "переброс между счетами"
            if (!$this->createTransferOperation($model)){
                return false;
            }
            break;
            default: // иначе - просто сохранить операцию
            if (!$model->save()){
                return false;
            }
            break;
        }

        // if (!$model->save()) {
        //     return false;
        // }

        return true;
    }

    public function createTransferOperation(&$model)
    {
        var_dump($model->attributes);
        echo $model->source_id2;
        exit;
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
            ->orderBy('date_picked desc, id desc')
            ->limit($count)
            ->offset($from)
            ->asArray()
            ->all();
    }

    // получить все операции за период
    public function getOperationsForPeriod($userId, $datesArr, $from = '', $count = '')
    {
        return Operation::find()
        ->select(['operations.id id', 'operations.name name', 'operations.sum sum', 'operations.type type', 'operations.date_picked', 'c.name cname', 's.name sname'])
        ->where(['operations.user_id' => $userId])
        ->joinWith('category c')
        ->joinWith('source s')
        ->orderBy('date_picked desc, id desc')
        ->andWhere(['between', 'date_picked', $datesArr[0], $datesArr[1]])
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

    // посчитать текущий баланс по ВСЕМ источникам
    public function getTotalBalance($userId){
        // итоговый правильный запрос - left join, чтобы вывести даже те источники, по которым не было движений
        // SELECT s.name, s.user_id, (ifnull(sum(CASE when o.type=1 THEN -sum else sum end), 0) + s.total) balance FROM `sources` s 
        // left join operations o on s.id = o.source_id where s.user_id = 15 group by s.name

        return Sources::find()
        ->alias('s')
        ->select(['s.name', '(ifnull(sum(CASE when o.type=1 THEN -sum else sum end), 0) + s.total) balance'])
        ->leftJoin('operations o', 's.id = o.source_id')
        ->where(['s.user_id' => $userId])
        ->groupBy('s.name')
        ->asArray()
        ->all();

    }
}

<?php

namespace app\components;

use app\models\Sources;
use yii\base\Component;
use app\models\Operation;
use yii\helpers\ArrayHelper;
use app\helpers\DateHelper;

class DashboardComponent extends Component
{
    public function getModel()
    {
        return new Operation();
    }

    // получить сгруппированнные по источникам (наличные/безналичные) операции пользователя за период
    public function getSummary($userId, $datesArr, $flag = false)
    {
        // $flag определяет нужна ли разбивка по датам:
        // - true - нужна, для отчетов за КАЖДЫЙ день, 
        // - false - НЕ нужна, для отчета за ПЕРИОД)

        $datePickedAdd = $flag ? ', o.date_picked' : '';

        return $this->getModel()::find()
            ->alias('o')
            ->select([
                'c.name',
                'ifnull(sum(case when s.type=2 
                        then 
                            case when o.type=2
                            then o.sum
                            else -o.sum
                            end
                        end),0) 
                    cash',
                'ifnull(sum(case when s.type=1 
                        then 
                            case when o.type=2
                            then o.sum
                            else -o.sum
                            end
                        end),0) 
                    card',
                'c.id category_id',
                "GROUP_CONCAT(o.name separator ', ') description" . $datePickedAdd,
            ])
            ->innerJoin('sources s', 'o.source_id=s.id')
            ->innerJoin('category c', 'o.category_id=c.id')
            ->where(['o.user_id' => $userId])
            ->andWhere(['between', 'date_picked', $datesArr[0], $datesArr[1]])
            ->groupBy('c.name' . $datePickedAdd)
            ->orderBy('o.date_picked desc')
            ->asArray()
            ->all();
    }

    // переиндексировать массив операций по числам - 'число1' => ['категория1' => 'данные категории1', ...], 
    public function reIndexOperations($arr)
    {
        return ArrayHelper::index($arr, null, 'date_picked');
    }

    public function addIndexOperations($arr, $newIndex)
    {
        $newArr = [];
        $newArr[$newIndex] = $arr;
        return $newArr;
    }

    // показать все операции пользователя в данной категории за день 
    public function getCategoryOperationsByDay($userId, $categoryId, $day)
    {
        return $this->getModel()::find()
            ->alias('o')
            ->select(['id', 'sum', 'name', 'type', 'date_picked'])
            ->where(['user_id' => $userId, 'date_picked' => $day, 'category_id' => $categoryId])
            ->asArray()
            ->all();
    }

    public function getCategoryOperationsByPeriod($userId, $categoryId, $periodStr)
    {
        $periodAdd = explode('_', $periodStr);
        return $this->getModel()::find()
        ->alias('o')
        ->select(['id', 'sum', 'name', 'type', 'date_picked'])
        ->where(['user_id' => $userId, 'category_id' => $categoryId])
        ->andWhere(['between', 'date_picked', $periodAdd[0], $periodAdd[1]])
        ->orderBy('date_picked asc')
        ->asArray()
        ->all();
    }
}


    // ГОТОВЫЙ ЗАПРОС для формирования общей сводки по всем категориям за 1 день (2019-08-02) для 1 пользователя с id=15
    // select c.name, 
    // 	ifnull(sum(case when s.type=2 
    //         then 
    //         	case when o.type=2
    //         	then o.sum
    //        		else -o.sum
    //         	end
    //         end),0) 
    //      cash, 	
    //     ifnull(sum(case when s.type=1 
    //         then 
    //         	case when o.type=2
    //         	then o.sum
    //        		else -o.sum
    //             end
    //        	end),0) card,
    //         GROUP_CONCAT(o.name) description
    //     from operations o 
    // inner join sources s on o.source_id=s.id 
    // inner join category c on o.category_id=c.id 
    // where o.user_id=15 and date_picked='2019-08-02'
    // group by c.name

    // ГОТОВЫЙ ЗАПРОС для формирования ОБЩЕЙ сводки по категориям за ПЕРИОД для 1 пользователя
    // select c.name, 
    // 	ifnull(sum(case when s.type=2 
    //         then 
    //         	case when o.type=2
    //         	then o.sum
    //        		else -o.sum
    //         	end
    //         end),0) 
    //      cash, 	
    //     ifnull(sum(case when s.type=1 
    //         then 
    //         	case when o.type=2
    //         	then o.sum
    //        		else -o.sum
    //             end
    //        	end),0) card,
    //         GROUP_CONCAT(o.name) description
    //     from operations o 
    // inner join sources s on o.source_id=s.id 
    // inner join category c on o.category_id=c.id 
    // where o.user_id=15 and date_picked between '2019-07-02' and '2019-08-02'
    // group by c.name
    // order by o.date_picked desc

    // ГОТОВЫЙ ЗАПРОС для формирования сводки по КАЖДОМУ ДНЮ категориям за ПЕРИОД для 1 пользователя
    // select c.name, 
    // 	ifnull(sum(case when s.type=2 
    //         then 
    //         	case when o.type=2
    //         	then o.sum
    //        		else -o.sum
    //         	end
    //         end),0) 
    //      cash, 	
    //     ifnull(sum(case when s.type=1 
    //         then 
    //         	case when o.type=2
    //         	then o.sum
    //        		else -o.sum
    //             end
    //        	end),0) card,
    //         GROUP_CONCAT(o.name) description,
    //         o.date_picked
    //     from operations o 
    // inner join sources s on o.source_id=s.id 
    // inner join category c on o.category_id=c.id 
    // where o.user_id=15 and date_picked between '2019-07-02' and '2019-08-02'
    // group by c.name, o.date_picked
    // order by o.date_picked desc

<?php

namespace app\components\dataproviders;

use yii\data\ActiveDataProvider;
use app\models\Operation;

class OperationSearch extends Operation
{

  // фильтрация будет только по тем пар-рам, которые указаны в rules()
  public function rules()
  {
    return [
        ['name', 'string', 'max' => 200],
        ['type', 'in', 'range' => [1, 2]],
        ['sum', 'number'],
        ['category_id', 'safe'],
        ['source_id', 'safe'],

    ];
  }

  public function search($user_id, $params)
  {
    $query = Operation::find();

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'pageSize' => 10,
        ],
      // сортировка по умолчанию
        'sort' => [
            'defaultOrder' => [
                'type' => SORT_ASC
            ]
        ]
    ]);

    // DataProvider всегда будет показывать категории только залогиненного пользователя
    $query->andFilterWhere(['operations.user_id' => $user_id]);

    // а если пришел get-запрос с параметрами фильтрации, загружаем данные формы поиска и производим валидацию
    if (!($this->load($params) && $this->validate())) {
      return $dataProvider;
    }
    $query->joinWith('category');
    $query->joinWith('source');

    // изменяем запрос добавляя в него фильтрацию
    $query->andFilterWhere(['like', 'operations.name', $this->name]);
    $query->andFilterWhere(['like', 'operations.sum', $this->sum]);
    $query->andFilterWhere(['like', 'category.name', $this->category_id]);
    $query->andFilterWhere(['like', 'sources.name', $this->source_id]);
    $query->andFilterWhere(['like', 'operations.type', $this->type]);

    return $dataProvider;
  }
}

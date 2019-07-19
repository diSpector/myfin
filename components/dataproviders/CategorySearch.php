<?php

namespace app\components\dataproviders;

use yii\data\ActiveDataProvider;
use app\models\Category;

class CategorySearch extends Category
{

    // фильтрация будет только по тем пар-рам, которые указаны в rules()
    public function rules()
    {
        return [
            ['name', 'string', 'max' => 200],
            ['type', 'in', 'range' => [1, 2]],
        ];
    }

    public function search($user_id, $params)
    {
        $query = Category::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            // сотрировка по умолчанию
            'sort' => [
                'defaultOrder' => [
                    'type' => SORT_ASC
                ]
            ]
        ]);

        // DataProvider всегда будет показывать категории только залогиненного пользователя
        $query->andFilterWhere(['user_id' => $user_id]);

        // а если пришел get-запрос с параметрами фильтрации, загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // изменяем запрос добавляя в него фильтрацию
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }



    // public function getDataProvider($params)
    // {
    //     $query = Category::find();
    //     $provider = new ActiveDataProvider(
    //         [
    //             'query' => $query,
    //             'pagination' => [
    //                 'pageSize' => 10,
    //             ],
    //         ]
    //     );
    //     // $query->andFilterWhere(['user_id' => $params['user_id']]);
    //     $query->andFilterWhere(['user_id' => $params['user_id']]);
    //     $query->andFilterWhere(['type' => $params['type']]);
    //     return $provider;
    // }


}

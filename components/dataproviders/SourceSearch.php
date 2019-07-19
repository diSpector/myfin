<?php

namespace app\components\dataproviders;

use yii\data\ActiveDataProvider;
use app\models\Sources;

class SourceSearch extends Sources
{
    public function getDataProvider($params)
    {
        $query = Sources::find();
        $provider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]
        );
        $query->andFilterWhere(['user_id' => $params['user_id']]);
        return $provider;
    }
}

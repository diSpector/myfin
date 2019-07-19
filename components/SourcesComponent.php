<?php

namespace app\components;

use Yii;
use app\models\Sources;
use yii\base\Component;
use app\components\dataproviders\SourceSearch;

class SourcesComponent extends Component
{
    public function getModel($params = null)
    {
        $model = new Sources();
        return $model;
    }

    public function createNewSource(&$model)
    {
        $model->user_id = Yii::$app->user->id;
        if (!$model->save()) {
            return false;
        }

        return true;
    }

    public function getSearchProvider($params)
    {
        $model = new SourceSearch();
        return $model->getDataProvider($params);
    }

    public function updateSource(&$model)
    {
        if (!$model->update()) {
            return false;
        }

        return true;
    }

    public function deleteSource(&$model)
    {
        if (!$model->delete()) {
            return false;
        }

        return true;
    }

    public function getSourceById($id)
    {
        return $this->getModel()::find()->where(['id' => $id])->one();
    }
}

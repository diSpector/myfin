<?php

namespace app\controllers\actions\operation;

use Yii;
use yii\base\Action;
use yii\web\Response;

class CreateOperationAction extends Action
{
    public function run()
    {
        // изначально не выбран тип операции (приход/расход), поэтому поле с категориями не показывается 
        $init = false;
        $comp = Yii::$app->operation;
        $model = $comp->getModel();

        $userId = Yii::$app->user->id;
        // $categories = $comp->getSearchProvider($userId, Yii::$app->request->get());

        // получить все типы операций, а также категории и источники пользователя
        $types = $comp->getOperationTypes();
        $categories = $comp->getUserCategories($userId);
        $sources = $comp->getUserSources($userId);

        if (Yii::$app->request->isAjax) {
            // настройки ответа
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;

            $selectedType = Yii::$app->request->post()['id'];

            if (!$selectedType) {
                $response->data = [
                    'error' => true,
                ];
                return $response;
            }

            $categories = $comp->getUserCategories($userId, ['id' => $selectedType]);
            // var_dump($categories);

            // var_dump($selectedType);
            // $comp = Yii::$app->operation;
            // $filterModel = $comp->getOperationSearch();
            // $operations = $comp->getSearchProvider($userId, Yii::$app->request->post());

            // return $this->controller->renderAjax('_form', [
            // 'model' => $model,
            // 'types' => $types,
            // 'categories' => $categories,
            // 'sources' => $sources,

            // 'dataProvider' => $operations,
            // 'filterModel' => $filterModel,
            // ]);

            $response->data = [
                'categories' => $categories,
                'type' => $selectedType,
            ];

            return $response;
        }

        // if ($model->load(Yii::$app->request->post())) {
        //     if ($comp->createNewCategory($model)) {
        //         Yii::$app->session->setFlash('success', 'Добавлена новая категория - ' . $model->name);
        //         return $this->controller->redirect('view');
        //     } else {
        //         Yii::$app->session->setFlash('error', 'Ошибка. Добавление новой категории не удалось');
        //     }
        // }

        return $this->controller->render('create', [
            'model' => $model,
            // 'dataProvider' => $categories,
            'types' => $types,
            'categories' => $categories,
            'sources' => $sources,
            'init' => $init,
        ]);
    }
}

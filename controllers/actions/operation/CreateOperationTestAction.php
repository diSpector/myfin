<?php

namespace app\controllers\actions\operation;

use app\components\OperationComponent;
use Yii;
use yii\base\Action;
use yii\web\Response;

class CreateOperationTestAction extends Action
{
  public function run()
  {
    // изначально не выбран тип операции (приход/расход), поэтому поле с категориями не показывается
    /** @var OperationComponent $comp */
    $comp = Yii::$app->operation;
    $userId = Yii::$app->user->id;
    //    $types = $comp->getOperationTypes();
    $types = $comp->getOperationTypesForUser($userId);

    $model = $comp->getModel();

    //     $categories = $comp->getSearchProvider($userId, Yii::$app->request->get());

    // определяем видимость виджета
    $categories = $comp->getUserCategories($userId);
    $sources = $comp->getUserSources($userId);
    $isVisible = $categories && $sources;

    if (!$isVisible) {
      $this->controller->redirect('view');
    }

    if (Yii::$app->request->isAjax) {
      // получить тип операции - расход, приход
      $selectedType = Yii::$app->request->post()['id'];

      if (!$selectedType) {
        return null;
      }

      // получить все типы операций, а также категории и источники пользователя
      // $types = $comp->getOperationTypes();
      $types = $comp->getOperationTypesForUser($userId);

      $categories = $comp->getUserCategories($userId, ['id' => $selectedType]);
      $sources = $comp->getUserSources($userId);

      // по умолчанию проставить сегодняшнюю дату
      $model->date_picked = date('Y-m-d');;

      // $comp = Yii::$app->operation;
      // $filterModel = $comp->getOperationSearch();
      // $operations = $comp->getSearchProvider($userId, Yii::$app->request->post());

      return $this->controller->renderAjax('_form', [
        'model' => $model,
        'selectedType' => $selectedType,
        'categories' => $categories,
        'sources' => $sources,
        // 'dateToday' => $dateToday,
      ]);
    }

    if ($model->load(Yii::$app->request->post())) {
      if ($comp->createNewOperation($model)) {
        Yii::$app->session->setFlash('success', 'Добавлена новая операция ' . $model->name);
        return $this->controller->redirect('view');
      } else {
        Yii::$app->session->setFlash('error', 'Ошибка. Добавление новой операции не удалось');
      }
    }

    return $this->controller->render('create_test', [
      'types' => $types,
      'isVisible' => $isVisible,
    ]);
  }
}

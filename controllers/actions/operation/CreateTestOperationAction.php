<?php

namespace app\controllers\actions\operation;

use Yii;
use yii\base\Action;
use app\components\OperationComponent;

class CreateTestOperationAction extends Action
{
	public function run()
	{

		// изначально не выбран тип операции (приход/расход), поэтому поле с категориями не показывается
		/** @var OperationComponent $comp */
		$comp = Yii::$app->operation;
		$userId = Yii::$app->user->id;

		$types = $comp->getOperationTypesForUser($userId);

		// добавление в dropdownlist (приход/расход) пункта для перекидывания денег между счетами 
		$types[] = 'Перенос средств с одного счета на другой';
		// $model = $comp->getModel();

		// определяем видимость виджета - показывать только если есть хоть одна категория и источник
		$categories = $comp->getUserCategories($userId);
		$sources = $comp->getUserSources($userId);
		$isVisible = $categories && $sources;

		if (Yii::$app->request->isAjax) {
			// получить тип операции - расход, приход, трансфер
			$selectedType = Yii::$app->request->post()['id'];

			if (!$selectedType) {
				return null;
			}

			$model = $comp->getModel();

			// общий массив для вывода в любую вьюху - приход/расход или переброс между счетами
			$arrayForView = [
				'model' => $model,
				'selectedType' => $selectedType,
				'sources' => $sources,
			];

			// если выбран переброс между счетами
			if ($selectedType == '3') {
				$view = '_form_transfer';
				$model->scenario = 'transfer';

				// иначе, если выбран приход или расход
			} else {
				$view = '_form';
				// получить все операции выбранного типа для пользователя 
				$categories = $comp->getUserCategories($userId, ['id' => $selectedType]);
				$arrayForView = array_merge($arrayForView, ['categories' => $categories]);
			}

			// по умолчанию проставить сегодняшнюю дату
			$model->date_picked = date('Y-m-d');

			return $this->controller->renderAjax($view, $arrayForView);
		}

		// if ($model->load(Yii::$app->request->post())) {
		if (Yii::$app->request->post()) {
			$model = $comp->getModel();
			$request = Yii::$app->request;
			$operation = $request->post('Operation');

			if ($operation['type'] == 3) {
				$model->scenario = 'transfer';
			}

			$model->load(Yii::$app->request->post());

			if ($comp->createNewOperation($model)) {
				Yii::$app->session->setFlash('success', 'Добавлена новая операция ' . $model->name);
				return $this->controller->redirect('view');
			} else {
				// var_dump($model->errors);
				// exit;
				Yii::$app->session->setFlash('error', 'Ошибка. Добавление новой операции не удалось');
			}
		}

		return $this->controller->render('create_test', [
			'types' => $types,
			'isVisible' => $isVisible,
		]);
	}
}

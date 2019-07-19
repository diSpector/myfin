<?php

namespace app\components;

use yii\base\Component;
use app\rules\ViewCategoryOwnerRule;
// use app\rules\ViewCostCategoryOwnerRule;

class RbacComponent extends Component
{
    /**
     * @return \yii\rbac\ManagerInterface
     */

    public function generateRbacRules()
    {
        $authManager = $this->getAuthManager();
        $authManager->removeAll(); // каждый раз удаляем все данные из таблиц авторизации

        // создание ролей
        $admin = $authManager->createRole('admin');
        $user = $authManager->createRole('user');

        // добавление ролей
        $authManager->add($admin);
        $authManager->add($user);

        // создание разрешений
        // $editCostCategory = $authManager->createPermission('editCostCategory');
        // $editCostCategory->description = 'Редактирование и удаление категории расходов';

        // $editIncomeCategory = $authManager->createPermission('editIncomeCategory');
        // $editIncomeCategory->description = 'Редактирование и удаление категории доходов';

        $editCategory = $authManager->createPermission('editCategory');
        $editCategory->description = 'Редактирование и удаление категории';

        // $viewOwnerRule = new ViewCostCategoryOwnerRule();
        // $authManager->add($viewOwnerRule);
        // $editCostCategory->ruleName = $viewOwnerRule->name;

        $viewOwnerRule = new ViewCategoryOwnerRule();
        $authManager->add($viewOwnerRule);
        $editCategory->ruleName = $viewOwnerRule->name;

        $viewEditAll = $authManager->createPermission('viewEditAll');
        $viewEditAll->description = 'Просмотр и редактирование всех категорий расходов';

        // $authManager->add($editCostCategory);
        // $authManager->add($editIncomeCategory);
        $authManager->add($editCategory);
        $authManager->add($viewEditAll);

        // $authManager->addChild($user, $editCostCategory);
        // $authManager->addChild($user, $editIncomeCategory);
        $authManager->addChild($user, $editCategory);
        $authManager->addChild($admin, $user);
        $authManager->addChild($admin, $viewEditAll);

        $authManager->assign($admin, 14); // админ
        $authManager->assign($user, 15); // пользователь
        $authManager->assign($user, 16); // пользователь
        $authManager->assign($user, 17); // пользователь
        $authManager->assign($user, 18); // пользователь



        // // создание разрешений
        // $createCostCategory = $authManager->createPermission('createCostCategory');
        // $createCostCategory->description = 'Создание категории расходов';

        // // добавление разрешений
        // $authManager->add($createCostCategory);

        // // назначение ролей
        // $authManager->addChild($user, $createCostCategory);
        // $authManager->addChild($admin, $user);

        // // присвоение ролей пользователям
        // $authManager->assign($user, 1); // пользователь
        // $authManager->assign($admin, 2); // админ

        // $createActivity = $authManager->createPermission('createActivity');
        // $createActivity->description = 'Создание активности';

        // // объявление автономного правила для этого разрешения и привязка
        // $viewOwnerRule = new ViewActivityOwnerRule();
        // $authManager->add($viewOwnerRule);

        // $viewActivity = $authManager->createPermission('viewActivity');
        // $viewActivity->description='Просмотр активности';
        // $viewActivity->ruleName = $viewOwnerRule->name;

        // $viewEditAll = $authManager->createPermission('viewEditAll');
        // $viewEditAll->description='Просмотр и редактирование всех активностей';
        // // добавление разрешений в базу
        // $authManager->add($createActivity);
        // $authManager->add($viewActivity);
        // $authManager->add($viewEditAll);
        // // раздача разрешений ролям
        // // пользователь - просмотр и создание активности
        // $authManager->addChild($user, $createActivity);
        // $authManager->addChild($user, $viewActivity);
        // // админ - наследует от пользователя + редактирует всё
        // $authManager->addChild($admin, $user);
        // $authManager->addChild($admin, $viewEditAll);
        // // дать конкретному пользователю конкретную роль
        // $authManager->assign($user, 1); // пользователь
        // $authManager->assign($admin, 2); // админ
    }
    // проверка, может ли пользователь создавать активность
    // public function canCreateActivity(){
    //     return \Yii::$app->user->can('createActivity');
    // }
    //    // проверка, может ли пользователь редактировать активность
    //    public function canEditActivity(){
    //        return \Yii::$app->user->can('editActivity');
    //    }

    // проверка, может ли пользователь просматривать/редактировать
    public function canViewEditAll(){
        return \Yii::$app->user->can('viewEditAll');
    }
    public function canViewActivity($activity)
    {
        return \Yii::$app->user->can('viewActivity', ['activity' => $activity]);
    }

    // public function canEditCostCategory($costcategory)
    // {
    //     return \Yii::$app->user->can('editCostCategory', ['costcategory' => $costcategory]);
    // }

    // public function canEditCostCategory($category)
    // {
    //     return \Yii::$app->user->can('editCategory', ['category' => $category]);
    // }

    public function canEditCategory($category)
    {
        return \Yii::$app->user->can('editCategory', ['category' => $category]);
    }

    private function getAuthManager()
    {
        return \Yii::$app->authManager;
    }
}

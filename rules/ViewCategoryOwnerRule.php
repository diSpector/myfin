<?php

namespace app\rules;

use Yii;
use yii\rbac\Item;
use yii\rbac\Rule;
use yii\web\HttpException;
use yii\helpers\ArrayHelper;

class ViewCategoryOwnerRule extends Rule
{
    public $name = 'ViewCategoryOwnerRule';
    /**
     * Executes the rule.
     *
     * @param string|int $user the user ID. This should be either an integer or a string representing
     * the unique identifier of a user. See [[\yii\web\User::id]].
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to [[CheckAccessInterface::checkAccess()]].
     * @return bool a value indicating whether the rule permits the auth item it is associated with.
     */
    public function execute($user, $item, $params)
    {
        $category = ArrayHelper::getValue($params, 'category');
        if (!$category) {
            // throw new \NotFoundException('Не указан параметр категории расходов');
            throw new HttpException(404, 'Неверно указана категория');
        }
        return $category->user_id == $user;
    }

    // public $name = 'ViewCostCategoryOwnerRule';
    // /**
    //  * Executes the rule.
    //  *
    //  * @param string|int $user the user ID. This should be either an integer or a string representing
    //  * the unique identifier of a user. See [[\yii\web\User::id]].
    //  * @param Item $item the role or permission that this rule is associated with
    //  * @param array $params parameters passed to [[CheckAccessInterface::checkAccess()]].
    //  * @return bool a value indicating whether the rule permits the auth item it is associated with.
    //  */
    // public function execute($user, $item, $params)
    // {
    //     $costcategory = ArrayHelper::getValue($params, 'costcategory');
    //     if (!$costcategory) {
    //         // throw new \NotFoundException('Не указан параметр категории расходов');
    //         throw new HttpException(404, 'Неверно указана категория расходов');
    //     }
    //     return $costcategory->user_id == $user;
    // }
}

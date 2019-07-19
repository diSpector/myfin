<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $password_hash
 * @property int $enabled
 * @property string $date_created
 * @property string $last_login
 *
 * @property CostCategory[] $costCategories
 * @property CostSources[] $costSources
 * @property Costs[] $costs
 * @property IncomeCategory[] $incomeCategories
 * @property IncomeSources[] $incomeSources
 * @property Incomes[] $incomes
 */
class UsersBase extends \app\base\BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'name'], 'required'],
            [['enabled'], 'integer'],
            [['date_created', 'last_login'], 'safe'],
            [['email', 'name'], 'string', 'max' => 45],
            [['password_hash'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Адрес электронной почты',
            'name' => 'Имя',
            'password_hash' => 'Password Hash',
            'enabled' => 'Enabled',
            'date_created' => 'Date Created',
            'last_login' => 'Last Login',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCostCategories()
    {
        return $this->hasMany(CostCategory::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCostSources()
    {
        return $this->hasMany(CostSources::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCosts()
    {
        return $this->hasMany(Costs::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncomeCategories()
    {
        return $this->hasMany(IncomeCategory::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncomeSources()
    {
        return $this->hasMany(IncomeSources::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncomes()
    {
        return $this->hasMany(Incomes::className(), ['user_id' => 'id']);
    }
}

<?php

namespace app\models\base;

use Yii;
use app\models\Users;
use app\models\Sources;
use app\models\Category;
use app\models\OperationForm;

/**
 * This is the model class for table "operations".
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property int $source_id
 * @property string $sum
 * @property string $name
 * @property int $type
 * @property string $date_created
 * @property string $date_picked
 *
 * @property Category $category
 * @property OperationForm $type0
 * @property Sources $source
 * @property Users $user
 */
class OperationBase extends \app\base\BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'category_id', 'source_id', 'sum', 'type', 'date_picked'], 'required'],
            [['user_id', 'category_id', 'source_id', 'type'], 'integer'],
            [['sum'], 'number'],
            [['date_created', 'date_picked'], 'safe'],
            [['name'], 'string', 'max' => 200],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => OperationForm::className(), 'targetAttribute' => ['type' => 'id']],
            [['source_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sources::className(), 'targetAttribute' => ['source_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'category_id' => 'Category ID',
            'source_id' => 'Source ID',
            'sum' => 'Sum',
            'name' => 'Name',
            'type' => 'Type',
            'date_created' => 'Date Created',
            'date_picked' => 'Date Picked',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType0()
    {
        return $this->hasOne(OperationForm::className(), ['id' => 'type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(Sources::className(), ['id' => 'source_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}

<?php

namespace app\models\base;

use Yii;
use app\models\Users;
use app\models\OperationForm;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property int $type
 *
 * @property OperationForm $type0
 * @property Users $user
 * @property Operations[] $operations
 */
class CategoryBase extends \app\base\BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'type'], 'required'],
            [['user_id', 'type'], 'integer'],
            [['name'], 'string', 'max' => 200],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => OperationForm::className(), 'targetAttribute' => ['type' => 'id']],
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
            'name' => 'Name',
            'type' => 'Type',
        ];
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
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperations()
    {
        return $this->hasMany(Operations::className(), ['category_id' => 'id']);
    }
}

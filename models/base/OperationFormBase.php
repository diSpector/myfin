<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "operation_form".
 *
 * @property int $id
 * @property string $name
 *
 * @property Category[] $categories
 * @property DefaultCategory[] $defaultCategories
 * @property Operations[] $operations
 */
class OperationFormBase extends \app\base\BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operation_form';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefaultCategories()
    {
        return $this->hasMany(DefaultCategory::className(), ['type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperations()
    {
        return $this->hasMany(Operations::className(), ['type' => 'id']);
    }
}

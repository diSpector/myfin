<?php

namespace app\models\base;

use Yii;
use app\models\OperationForm;

/**
 * This is the model class for table "default_category".
 *
 * @property int $id
 * @property string $name
 * @property int $type
 *
 * @property OperationForm $type0
 */
class DefaultCategoryBase extends \app\base\BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'default_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => OperationForm::className(), 'targetAttribute' => ['type' => 'id']],
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
}

<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "operation_type".
 *
 * @property int $id
 * @property string $name
 *
 * @property CostSources[] $costSources
 * @property IncomeSources[] $incomeSources
 */
class OperationTypeBase extends \app\base\BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operation_type';
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
    public function getCostSources()
    {
        return $this->hasMany(CostSources::className(), ['type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncomeSources()
    {
        return $this->hasMany(IncomeSources::className(), ['type' => 'id']);
    }
}

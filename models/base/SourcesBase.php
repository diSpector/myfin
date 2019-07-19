<?php

namespace app\models\base;

use Yii;
use app\models\Users;
use app\models\OperationType;

/**
 * This is the model class for table "sources".
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property int $user_id
 * @property string $total
 * @property string $date_created
 * @property string $date_updated
 *
 * @property Costs[] $costs
 * @property InitState[] $initStates
 * @property OperationType $type0
 * @property Users $user
 */
class SourcesBase extends \app\base\BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sources';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'user_id', 'total'], 'required'],
            [['type', 'user_id'], 'integer'],
            [['total'], 'number'],
            [['date_created', 'date_updated'], 'safe'],
            [['name'], 'string', 'max' => 45],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => OperationType::className(), 'targetAttribute' => ['type' => 'id']],
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
            'name' => 'Name',
            'type' => 'Type',
            'user_id' => 'User ID',
            'total' => 'Total',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCosts()
    {
        return $this->hasMany(Costs::className(), ['source_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInitStates()
    {
        return $this->hasMany(InitState::className(), ['source_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType0()
    {
        return $this->hasOne(OperationType::className(), ['id' => 'type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}

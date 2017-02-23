<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data".
 *
 * @property string $id
 * @property string $time
 * @property string $number
 * @property string $name
 * @property string $event
 * @property string $status
 * @property string $create_at
 * @property string $file_id
 *
 * @property File $file
 * @property Person[] $people
 */
class Data extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time', 'number', 'name', 'event', 'create_at', 'file_id'], 'required'],
            [['number', 'file_id'], 'integer'],
            [['create_at'], 'safe'],
            [['time', 'event'], 'string', 'max' => 71],
            [['name'], 'string', 'max' => 127],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'time' => Yii::t('app', 'Time'),
            'number' => Yii::t('app', 'Number'),
            'name' => Yii::t('app', 'Name'),
            'event' => Yii::t('app', 'Event'),
            'status' => Yii::t('app', 'Status'),
            'create_at' => Yii::t('app', 'Create At'),
            'file_id' => Yii::t('app', 'File ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeople()
    {
        return $this->hasMany(Person::className(), ['data_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\DataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\DataQuery(get_called_class());
    }
}

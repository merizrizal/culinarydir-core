<?php

namespace core\models;

/**
 * This is the model class for table "settings".
 *
 * @property int $setting_id
 * @property string $setting_name
 * @property string $setting_value
 * @property string $type
 * @property string $created_at
 * @property string $updated_at
 */
class Settings extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['setting_id', 'setting_name'], 'required'],
            [['setting_id'], 'default', 'value' => null],
            [['setting_id'], 'integer'],
            [['setting_value'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['setting_name'], 'string', 'max' => 96],
            [['type'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'setting_id' => \Yii::t('app', 'Setting ID'),
            'setting_name' => \Yii::t('app', 'Setting Name'),
            'setting_value' => \Yii::t('app', 'Setting Value'),
            'type' => \Yii::t('app', 'Type'),
            'created_at' => \Yii::t('app', 'Created At'),
            'updated_at' => \Yii::t('app', 'Updated At'),
        ];
    }
}

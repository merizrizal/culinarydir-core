<?php

namespace core\models;


/**
 * This is the model class for table "driver_attachment".
 *
 * @property string $id
 * @property string $type
 * @property string $file_name
 * @property string $created_at
 * @property string $user_created
 * @property string $updated_at
 * @property string $user_updated
 *
 * @property User $userCreated
 * @property User $userUpdated
 */
class DriverAttachment extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'driver_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'file_name'], 'required'],
            [['file_name'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['id', 'type', 'user_created', 'user_updated'], 'string', 'max' => 32],
            [['id'], 'unique'],
            [['user_created'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_created' => 'id']],
            [['user_updated'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_updated' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'type' => \Yii::t('app', 'Type'),
            'file_name' => \Yii::t('app', 'File Name'),
            'created_at' => \Yii::t('app', 'Created At'),
            'user_created' => \Yii::t('app', 'User Created'),
            'updated_at' => \Yii::t('app', 'Updated At'),
            'user_updated' => \Yii::t('app', 'User Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCreated()
    {
        return $this->hasOne(User::className(), ['id' => 'user_created']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserUpdated()
    {
        return $this->hasOne(User::className(), ['id' => 'user_updated']);
    }
}

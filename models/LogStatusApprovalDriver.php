<?php

namespace core\models;


/**
 * This is the model class for table "log_status_approval_driver".
 *
 * @property string $id
 * @property string $application_driver_id
 * @property string $status_approval_driver_id
 * @property bool $is_actual
 * @property string $note
 * @property int $application_driver_counter
 * @property string $created_at
 * @property string $user_created
 * @property string $updated_at
 * @property string $user_updated
 *
 * @property ApplicationDriver $applicationDriver
 * @property StatusApprovalDriver $statusApprovalDriver
 * @property User $userCreated
 * @property User $userUpdated
 * @property LogStatusApprovalDriverAction[] $logStatusApprovalDriverActions
 */
class LogStatusApprovalDriver extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_status_approval_driver';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_driver_id', 'status_approval_driver_id', 'is_actual'], 'required'],
            [['is_actual'], 'boolean'],
            [['note'], 'string'],
            [['application_driver_counter'], 'default', 'value' => null],
            [['application_driver_counter'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['id', 'application_driver_id', 'user_created', 'user_updated'], 'string', 'max' => 32],
            [['status_approval_driver_id'], 'string', 'max' => 7],
            [['id'], 'unique'],
            [['application_driver_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationDriver::className(), 'targetAttribute' => ['application_driver_id' => 'id']],
            [['status_approval_driver_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusApprovalDriver::className(), 'targetAttribute' => ['status_approval_driver_id' => 'id']],
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
            'application_driver_id' => \Yii::t('app', 'Application Driver ID'),
            'status_approval_driver_id' => \Yii::t('app', 'Status Approval Driver ID'),
            'is_actual' => \Yii::t('app', 'Is Actual'),
            'note' => \Yii::t('app', 'Note'),
            'application_driver_counter' => \Yii::t('app', 'Application Driver Counter'),
            'created_at' => \Yii::t('app', 'Created At'),
            'user_created' => \Yii::t('app', 'User Created'),
            'updated_at' => \Yii::t('app', 'Updated At'),
            'user_updated' => \Yii::t('app', 'User Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationDriver()
    {
        return $this->hasOne(ApplicationDriver::className(), ['id' => 'application_driver_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusApprovalDriver()
    {
        return $this->hasOne(StatusApprovalDriver::className(), ['id' => 'status_approval_driver_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogStatusApprovalDriverActions()
    {
        return $this->hasMany(LogStatusApprovalDriverAction::className(), ['log_status_approval_driver_id' => 'id']);
    }
}

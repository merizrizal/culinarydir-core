<?php

namespace core\models;


/**
 * This is the model class for table "status_approval_driver_require".
 *
 * @property string $id
 * @property string $status_approval_driver_id
 * @property string $require_status_approval_driver_id
 * @property string $created_at
 * @property string $user_created
 * @property string $updated_at
 * @property string $user_updated
 *
 * @property StatusApprovalDriver $statusApprovalDriver
 * @property StatusApprovalDriver $requireStatusApprovalDriver
 * @property User $userCreated
 * @property User $userUpdated
 */
class StatusApprovalDriverRequire extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status_approval_driver_require';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_approval_driver_id', 'require_status_approval_driver_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['id', 'user_created', 'user_updated'], 'string', 'max' => 32],
            [['status_approval_driver_id', 'require_status_approval_driver_id'], 'string', 'max' => 7],
            [['id'], 'unique'],
            [['status_approval_driver_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusApprovalDriver::className(), 'targetAttribute' => ['status_approval_driver_id' => 'id']],
            [['require_status_approval_driver_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusApprovalDriver::className(), 'targetAttribute' => ['require_status_approval_driver_id' => 'id']],
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
            'status_approval_driver_id' => \Yii::t('app', 'Status Approval Driver ID'),
            'require_status_approval_driver_id' => \Yii::t('app', 'Require Status Approval Driver ID'),
            'created_at' => \Yii::t('app', 'Created At'),
            'user_created' => \Yii::t('app', 'User Created'),
            'updated_at' => \Yii::t('app', 'Updated At'),
            'user_updated' => \Yii::t('app', 'User Updated'),
        ];
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
    public function getRequireStatusApprovalDriver()
    {
        return $this->hasOne(StatusApprovalDriver::className(), ['id' => 'require_status_approval_driver_id']);
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

<?php

namespace core\models;


/**
 * This is the model class for table "status_approval_driver".
 *
 * @property string $id
 * @property string $name
 * @property string $note
 * @property string $instruction
 * @property string $status
 * @property int $order
 * @property bool $condition
 * @property int $branch
 * @property int $group
 * @property bool $not_active
 * @property string $execute_action
 * @property string $created_at
 * @property string $user_created
 * @property string $updated_at
 * @property string $user_updated
 *
 * @property LogStatusApprovalDriver[] $logStatusApprovalDrivers
 * @property User $userCreated
 * @property User $userUpdated
 * @property StatusApprovalDriverAction[] $statusApprovalDriverActions
 * @property StatusApprovalDriverRequire[] $statusApprovalDriverRequires
 * @property StatusApprovalDriverRequire[] $statusApprovalDriverRequires0
 * @property StatusApprovalDriverRequireAction[] $statusApprovalDriverRequireActions
 */
class StatusApprovalDriver extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status_approval_driver';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'status', 'order', 'branch', 'group'], 'required'],
            [['note', 'instruction', 'status', 'execute_action'], 'string'],
            [['order', 'branch', 'group'], 'default', 'value' => null],
            [['order', 'branch', 'group'], 'integer'],
            [['condition', 'not_active'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['id'], 'string', 'max' => 7],
            [['name'], 'string', 'max' => 64],
            [['user_created', 'user_updated'], 'string', 'max' => 32],
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
            'name' => \Yii::t('app', 'Name'),
            'note' => \Yii::t('app', 'Note'),
            'instruction' => \Yii::t('app', 'Instruction'),
            'status' => \Yii::t('app', 'Status'),
            'order' => \Yii::t('app', 'Order'),
            'condition' => \Yii::t('app', 'Condition'),
            'branch' => \Yii::t('app', 'Branch'),
            'group' => \Yii::t('app', 'Group'),
            'not_active' => \Yii::t('app', 'Not Active'),
            'execute_action' => \Yii::t('app', 'Execute Action'),
            'created_at' => \Yii::t('app', 'Created At'),
            'user_created' => \Yii::t('app', 'User Created'),
            'updated_at' => \Yii::t('app', 'Updated At'),
            'user_updated' => \Yii::t('app', 'User Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogStatusApprovalDrivers()
    {
        return $this->hasMany(LogStatusApprovalDriver::className(), ['status_approval_driver_id' => 'id']);
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
    public function getStatusApprovalDriverActions()
    {
        return $this->hasMany(StatusApprovalDriverAction::className(), ['status_approval_driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusApprovalDriverRequires()
    {
        return $this->hasMany(StatusApprovalDriverRequire::className(), ['status_approval_driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusApprovalDriverRequires0()
    {
        return $this->hasMany(StatusApprovalDriverRequire::className(), ['require_status_approval_driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusApprovalDriverRequireActions()
    {
        return $this->hasMany(StatusApprovalDriverRequireAction::className(), ['status_approval_driver_id' => 'id']);
    }
}

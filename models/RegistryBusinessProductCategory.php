<?php

namespace core\models;


/**
 * This is the model class for table "registry_business_product_category".
 *
 * @property string $id
 * @property string $unique_id
 * @property string $registry_business_id
 * @property string $product_category_id
 * @property bool $is_active
 * @property string $created_at
 * @property string $user_created
 * @property string $updated_at
 * @property string $user_updated
 *
 * @property ProductCategory $productCategory
 * @property RegistryBusiness $registryBusiness
 * @property User $userCreated
 * @property User $userUpdated
 */
class RegistryBusinessProductCategory extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'registry_business_product_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unique_id', 'registry_business_id', 'product_category_id'], 'required'],
            [['is_active'], 'boolean'],
            [['created_at', 'updated_at', 'product_category_id'], 'safe'],
            [['id', 'registry_business_id', 'user_created', 'user_updated'], 'string', 'max' => 32],
            [['unique_id'], 'string', 'max' => 65],
            [['unique_id'], 'unique'],
            [['id'], 'unique'],
            [['product_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['product_category_id' => 'id']],
            [['registry_business_id'], 'exist', 'skipOnError' => true, 'targetClass' => RegistryBusiness::className(), 'targetAttribute' => ['registry_business_id' => 'id']],
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
            'unique_id' => \Yii::t('app', 'Unique ID'),
            'registry_business_id' => \Yii::t('app', 'Registry Business ID'),
            'product_category_id' => \Yii::t('app', 'Product Category ID'),
            'is_active' => \Yii::t('app', 'Is Active'),
            'created_at' => \Yii::t('app', 'Created At'),
            'user_created' => \Yii::t('app', 'User Created'),
            'updated_at' => \Yii::t('app', 'Updated At'),
            'user_updated' => \Yii::t('app', 'User Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'product_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistryBusiness()
    {
        return $this->hasOne(RegistryBusiness::className(), ['id' => 'registry_business_id']);
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

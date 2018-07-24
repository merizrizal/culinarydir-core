<?php

namespace core\models;

use Yii;

/**
 * This is the model class for table "product_category".
 *
 * @property int $id
 * @property bool $is_parent
 * @property string $name
 * @property bool $is_active
 * @property string $created_at
 * @property int $user_created
 * @property string $updated_at
 * @property int $user_updated
 *
 * @property BusinessProduct[] $businessProducts
 * @property BusinessProductCategory[] $businessProductCategories
 * @property Product[] $products
 * @property User $userCreated
 * @property User $userUpdated
 * @property RegistryBusinessProductCategory[] $registryBusinessProductCategories
 */
class ProductCategory extends \sybase\SybaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_parent', 'name'], 'required'],
            [['is_parent', 'is_active'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_created', 'user_updated'], 'default', 'value' => null],
            [['user_created', 'user_updated'], 'integer'],
            [['name'], 'string', 'max' => 48],
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
            'id' => Yii::t('app', 'ID'),
            'is_parent' => Yii::t('app', 'Is Parent'),
            'name' => Yii::t('app', 'Product Category'),
            'is_active' => Yii::t('app', 'Is Active'),
            'created_at' => Yii::t('app', 'Created At'),
            'user_created' => Yii::t('app', 'User Created'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_updated' => Yii::t('app', 'User Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessProducts()
    {
        return $this->hasMany(BusinessProduct::className(), ['product_category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessProductCategories()
    {
        return $this->hasMany(BusinessProductCategory::className(), ['product_category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['product_category_id' => 'id']);
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
    public function getRegistryBusinessProductCategories()
    {
        return $this->hasMany(RegistryBusinessProductCategory::className(), ['product_category_id' => 'id']);
    }
}

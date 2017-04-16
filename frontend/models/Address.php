<?php

namespace frontend\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property integer $member_id
 * @property string $tel
 * @property integer $status
 * @property integer $create_add
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address'], 'required'],
            [['member_id', 'status', 'create_add'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['province','city','area'],'string'],
            [['address'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '收货人',
            'address' => '详细地址',
            'member_id' => '所属用户',
            'tel' => '手机号',
            'status' => '默认地址',
            'create_add' => '添加时间',
        ];
    }
}

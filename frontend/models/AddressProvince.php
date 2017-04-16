<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address_province".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 */
class AddressProvince extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address_province';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code'], 'string', 'max' => 6],
            [['name'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'code' => '省份编码',
            'name' => '省份名称',
        ];
    }
}

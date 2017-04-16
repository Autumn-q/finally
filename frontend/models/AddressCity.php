<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address_city".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $provinceCode
 */
class AddressCity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address_city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'provinceCode'], 'required'],
            [['code', 'provinceCode'], 'string', 'max' => 6],
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
            'code' => '城市编码',
            'name' => '城市名称',
            'provinceCode' => '所属省份编码',
        ];
    }
}

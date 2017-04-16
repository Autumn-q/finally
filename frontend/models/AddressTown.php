<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address_town".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $cityCode
 */
class AddressTown extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address_town';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'cityCode'], 'required'],
            [['code', 'cityCode'], 'string', 'max' => 6],
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
            'code' => '区县编码',
            'name' => '区县名称',
            'cityCode' => '所属城市编码',
        ];
    }
}

<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_gallery".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property string $path
 */
class GoodsGallery extends \yii\db\ActiveRecord
{
    public $imgFile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['path'], 'string', 'max' => 255],
            ['imgFile','file','extensions'=>['jpg','png','gif'], 'maxFiles' => 3, 'skipOnEmpty'=>false],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
//            'path' => '图片路径',
            'imgFile'=>'上传图片',
        ];
    }
}

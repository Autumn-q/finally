<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property string $sn
 * @property string $logo
 * @property integer $goods_category_id
 * @property integer $brand_id
 * @property string $market_price
 * @property string $shop_price
 * @property integer $stock
 * @property integer $in_on_sale
 * @property integer $status
 * @property integer $sort
 * @property integer $inputtime
 */
class Goods extends \yii\db\ActiveRecord
{
    public static $is_on_sale_name = [1=>'上架', 0=>'下架',];
    public static $status_name = [1=>'正常', 0=>'回收站',];
    public $logo_file;
    public $depth;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','market_price','shop_price', 'logo_file'], 'required'],
            [['goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'status', 'sort'], 'integer'],
            [['name'], 'string'],
            ['logo_file', 'file', 'extensions' => ['png','gif','jpg']],
            ['depth','safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名',
            'sn' => '货号',
            'logo_file' => 'logo',
            'goods_category_id' => '商品分类',
            'brand_id' => '品牌',
            'market_price' => '市场售价',
            'shop_price' => '本店售价',
            'stock' => '库存',
            'is_on_sale' => '是否上架',
            'status' => '正常 or 回收站',
            'sort' => '排序',
            'inputtime' => '添加时间',
        ];
    }
    //查出品牌数据
    public static function getBrand()
    {
        $rs = Brand::find()->all();
        return ArrayHelper::map($rs,'id','name');
    }
    //关联分类模型
    public function getCategoryName()
    {
        return $this->hasOne(GoodsCategory::className(),['id'=>'goods_category_id']);
    }
    //关联品牌模型
    public function getBrandName()
    {
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    }
}

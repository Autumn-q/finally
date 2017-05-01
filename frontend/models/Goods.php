<?php

namespace frontend\models;

use EasyWeChat\Message\News;
use Yii;

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
 * @property integer $is_on_sale
 * @property integer $status
 * @property integer $sort
 * @property integer $inputtime
 */
class Goods extends \yii\db\ActiveRecord
{
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
            [['name', 'sn', 'logo'], 'required'],
            [['goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'status', 'sort', 'inputtime'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name', 'sn'], 'string', 'max' => 50],
            [['logo'], 'string', 'max' => 100],
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
            'logo' => 'logo',
            'goods_category_id' => '商品分类id',
            'brand_id' => '品牌id',
            'market_price' => '市场售价',
            'shop_price' => '本店售价',
            'stock' => '库存',
            'is_on_sale' => '是否上架',
            'status' => '1正常 0回收站',
            'sort' => '排序',
            'inputtime' => '添加时间',
        ];
    }
    public function getGoodsIntro()
    {
        return $this->hasOne(GoodsIntro::className(),['goods_id'=>'id']);
    }
    public function getGoodsBrand()
    {
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    }
    //最热商品
    public static function port()
    {
        //查出最新的5个商品
        $articles = self::find()->orderBy(['inputtime'=>'SORT_DESC'])->limit(5)->all();

        $result = [];
        foreach ($articles as $article) {
            $news = new News([
                'title' => $article->name,
                'description' => '',
                'url' => 'http://www.baidu.com',
                'image' => $article->logo,
            ]);
            $result[] = $news;
        }
        return $result;
    }
    public static function hotSort()
    {
        //查出最新的5个商品
        $articles = self::find()->where(['is_on_sale'=>2])->limit(5)->all();

        $result = [];
        foreach ($articles as $article) {
            $news = new News([
                'title' => $article->name,
                'description' => '',
                'url' => 'http://www.baidu.com',
                'image' => $article->logo,
            ]);
            $result[] = $news;
        }
        return $result;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/3
 * Time: 10:31
 */

namespace backend\models;


use yii\base\Model;

class GoodsSearchForm extends Model
{
    public $name;
    public $sn;
    public $maxShop;
    public $minShop;
    public function rules()
    {
        return[
            ['name','string'],
            ['sn','string'],
            ['maxShop','double'],
            ['minShop','double'],
        ];
    }
    /*public function attributeLabels()
    {
        return [
            'name'=>'商品名',
            'sn'=>'货号',
            'maxShop'=>'最大价格',
            'minShop'=>'最小价格',
        ];
    }*/
    public function search($query)
    {

        if($this->name){
            $query->andWhere(['like','name',$this->name]);
        }
        if($this->sn){
            $query->andWhere(['like','sn',$this->sn]);
        }
        if($this->minShop){
            $query->andWhere(['>=','shop_price',$this->minShop]);
        }
        if($this->maxShop){
            $query->andWhere(['<=','shop_price',$this->maxShop]);
        }
    }
}
<?php

namespace frontend\controllers;

use frontend\models\Goods;
use frontend\models\GoodsCategory;

class IndexController extends \yii\web\Controller
{
    public $layout = 'index';
    public function actionIndex()
    {
        //查出所有一级分类
        $rows = GoodsCategory::find()->where(['parent_id'=>0])->all();
        return $this->render('index',['rows'=>$rows]);
    }
    public function actionList()
    {
        //接收传值
        $id = \Yii::$app->request->get('id');
        //根据id查出所有分类

        //查出所有商品数据
        $rows = Goods::find()->where(['goods_category_id'=>$id])->all();
        return $this->render('list',['id'=>$id,'rows'=>$rows]);

    }
    public function actionGoods($id)
    {
        //接收传值查出展示商品
        $rows = Goods::findOne($id);

        return $this->render('goods',['rows'=>$rows]);

    }

}

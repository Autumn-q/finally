<?php

namespace backend\controllers;

use backend\models\GoodsCategory;
use yii\data\Pagination;
use yii\db\Exception;
use yii\helpers\Json;
use yii\web\Request;
use backend\filters\AccessFilter;

class GoodsCategoryController extends \yii\web\Controller
{
    //添加过滤器
    public function behaviors()
    {
        return [
            'accessAction'=>[
                'class'=>AccessFilter::className(),
                'only'=>['index','add','del','edit'],
            ],
        ];

    }
    //展示商品分类
    public function actionIndex()
    {
        //封装变量
        $rows = GoodsCategory::find()->orderBy('tree,lft')->all();

        return $this->render('index', ['rows' => $rows]);
    }

    //增加商品分类
    public function actionAdd()
    {
        //实例对象
        $model = new GoodsCategory();
        $request = new Request();
        //判断是否有提交
        if ($model->load($request->post()) && $model->validate()) {
            if($model->parent_id == 0){
                $model->makeRoot();
            }else{
                //查找父类
                $parent = GoodsCategory::findOne(['id'=>$model->parent_id]);
                $model->prependTo($parent);

            }
            //添加成功,给用户一个提示并跳转到首页
            \yii::$app->session->setFlash('success','添加成功');
            return $this->redirect(['goods-category/index']);
        }
        //查出所有分类数据,并转化成json数据
        $rows = GoodsCategory::find()->asArray()->all();
        $rows[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        $rows = Json::encode($rows);

        return $this->render('add', ['model' => $model,'rows'=>$rows]);

    }

    //修改商品分类
    public function actionEdit($id)
    {
            //实例对象
            $model = GoodsCategory::findOne($id);
            $request = new Request();
            //判断是否有提交
            if ($model->load($request->post()) && $model->validate()) {

                //捕获错误
                try{
                    if($model->parent_id == 0){
                        //保存数据到父类中
                        $model->makeRoot();
                    }else{
                        //查找父类
                        $parent = GoodsCategory::findOne(['id'=>$model->parent_id]);
                        //保存子类数据,关联父类
                        $model->prependTo($parent);

                        //修改成功,给用户一个提示并跳转到首页
                        \yii::$app->session->setFlash('success','修改成功');
                        return $this->redirect(['goods-category/index']);
                    }
                }catch(Exception $e){
                    //补货到错误信息,并提示
                    $model->addError('parent_id',$e->getMessage());
                }

            }
            //查出所有分类数据,并转化成json数据
            $rows = GoodsCategory::find()->asArray()->all();
            $rows[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
            $rows = Json::encode($rows);

            return $this->render('add', ['model' => $model,'rows'=>$rows]);
    }

    //删除商品分类
    public function actionDel($id)
    {
        if(GoodsCategory::findOne(['parent_id' => $id])){
            //有值说明该分类下是有子类的,所以不能删除,给用户一个提示
            \yii::$app->session->setFlash('danger','该分类下有子类,不能删除');
            return $this->redirect(['goods-category/index']);
        }
        //如没有值name就查出来删除
        GoodsCategory::deleteAll(['id'=>$id]);
        return $this->redirect(['goods-category/index']);
    }

    //ztree测试
    public function actionTest()
    {
        $this->layout = false;

        return $this->render('test');
    }
}

<?php

namespace backend\controllers;

use backend\models\Menu;
use backend\filters\AccessFilter;

class MenuController extends \yii\web\Controller
{
    //添加过滤器
    /*public function behaviors()
    {
        return [
            'accessAction'=>[
                'class'=>AccessFilter::className(),
                'only'=>['index','add','del','edit'],
            ],
        ];

    }*/
    public function actionIndex()
    {
        $rows = Menu::find()->where(['=','parent_id',0])->all();
        return $this->render('index',['rows'=>$rows]);
    }
    //添加菜单
    public function actionAdd()
    {
        $model = new Menu();
        if($model->load(\Yii::$app->request->post())&&$model->validate()){
            //验证通过保存到数据库
            if($model->parent_id==0){
                $model->depth = 0;
            }else{
                $model->depth =1;
            }
            $model->save();
            //保存数据给用户一个提示,并跳转
            \Yii::$app->session->setFlash('success','添加成功');
            return $this->redirect(['menu/index']);
        }
        return $this->render('add',['model'=>$model]);
    }
    //修改菜单
    public function actionEdit($id)
    {
        $model = Menu::findOne($id);
        if($model->load(\Yii::$app->request->post())&&$model->validate()){
            if($model->parent_id==$id){
                \Yii::$app->session->setFlash('success','不能修改到自己的子类下');
                return $this->redirect(['menu/index']);
            }
            //验证通过保存到数据库
            $model->save();
            //保存数据给用户一个提示,并跳转
            \Yii::$app->session->setFlash('success','修改成功');
            return $this->redirect(['menu/index']);
        }
        return $this->render('add',['model'=>$model]);
    }
    //删除菜单
    public function actionDel($id)
    {
        Menu::findOne($id)->delete();
        //判断该分类下是否有子类,如果有,就不能删除
        if(Menu::findOne(['parent_id'=>$id])){
            \Yii::$app->session->setFlash('success','该分类下有子类,不能删除');
            return $this->redirect(['menu/index']);
        }
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['menu/index']);
    }

}

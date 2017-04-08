<?php

namespace backend\controllers;

use backend\models\PermissionForm;
use backend\filters\AccessFilter;

class PermissionController extends \yii\web\Controller
{
    //添加过滤器
   /* public function behaviors()
    {
        return [
            'accessAction'=>[
                'class'=>AccessFilter::className(),
                'only'=>['index','add','del'],
            ],
        ];

    }*/
    public function actionIndex()
    {
        $authManager = \Yii::$app->authManager;
        $rows = $authManager->getPermissions();
        //展示页面
        return $this->render('index',['rows'=>$rows]);
    }
    //添加权限
    public function actionAdd()
    {
        //实例表单模型
        $model = new PermissionForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //实例权限对象
            $authManager = \yii::$app->authManager;
            //创建权限
            $addManager = $authManager->createPermission($model->name);
            $addManager->description = $model->description;
            //保存权限
            $authManager->add($addManager);
            \Yii::$app->session->setFlash('success',$model->description.'权限添加成功');
            return $this->redirect(['permission/index']);
        }

        //展示页面
        return $this->render('add',['model'=>$model]);
    }
    //删除权限
    public function actionDel($name)
    {
        //实例模型
        $authManager = \Yii::$app->authManager;
        //找到要删除的权限
        $delManager = $authManager->getPermission($name);
        $authManager->remove($delManager);
        \Yii::$app->session->setFlash('success','权限删除成功');
        return $this->redirect(['permission/index']);

    }

}

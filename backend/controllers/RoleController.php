<?php

namespace backend\controllers;

use backend\models\RoleForm;
use backend\filters\AccessFilter;

class RoleController extends \yii\web\Controller
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
        $authManager = \Yii::$app->authManager;
        $rows = $authManager->getRoles();
        //展示页面
        return $this->render('index',['rows'=>$rows]);
    }
    //添加角色
    public function actionAdd(){
        $model = new RoleForm();
        //指定场景
        $model->scenario = RoleForm::SCENARIO_ADD;
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //实例对象
            $authManager = \Yii::$app->authManager;
            //创建角色
            $role = $authManager->createRole($model->name);
            $role->description = $model->description;
            //保存角色到数据库
            $authManager->add($role);

            //角色和权限建立联系
            foreach($model->permission as $permission){

                $authManager->addChild($role,$authManager->getPermission($permission));
            }
            \Yii::$app->session->setFlash('success',$model->description.'角色添加成功');
            return $this->redirect(['role/index']);
        }

        return $this->render('add',['model'=>$model]);
    }

    //修改角色
    public function actionEdit($name)
    {
        $model = new RoleForm();
        //获取该角色需要的数据
        $role = \Yii::$app->authManager->getRole($name);
        $permissions = \Yii::$app->authManager->getPermissionsByRole($name);
        //把值一一赋值给model
        $model->permission = array_keys($permissions);
        $model->name = $role->name;
        $model->description = $role->description;

        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //实例对象
            $authManager = \Yii::$app->authManager;

            $role->description = $model->description;
            //保存角色到数据库

            $authManager->update($role->name,$role);
            //角色和权限建立联系,先删除之前所有的权限
            $authManager->removeChildren($role);
            foreach($model->permission as $permission){

                $authManager->addChild($role,$authManager->getPermission($permission));
            }
            \Yii::$app->session->setFlash('success',$model->description.'角色修改成功');
            return $this->redirect(['role/index']);
        }

        return $this->render('add',['model'=>$model]);
    }

    //删除角色
    public function actionDel($name)
    {
        $authManager = \Yii::$app->authManager;
        //找到这个角色
        $role = $authManager->getRole($name);
        //删除角色
        $authManager->remove($role);
        \Yii::$app->session->setFlash('success','角色删除成功');
        return $this->redirect(['role/index']);
    }

}

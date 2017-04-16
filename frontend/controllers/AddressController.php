<?php

namespace frontend\controllers;

use frontend\models\Address;

class AddressController extends \yii\web\Controller
{
    public $layout = 'address';//指定布局文件

    //展示和添加收货地址
    public function actionIndex(){
        //找到当前登录用户的id
        $id = \Yii::$app->user->identity->getId();
        //查出该用户的所有收货地址信息
        $rows = Address::find()->where(['member_id'=>$id])->all();
        $model = new Address();
        //接收数据
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //一一赋值给model中的对应字段
            $row = $_POST;
            $model->province = $row['cmbProvince'];
            $model->city = $row['cmbCity'];
            $model->area = $row['cmbArea'];
            $model->member_id = $id;
            //判断是否设置为默认
            if($model->status){
                //查出该用户所有的收货地址
                $rows = Address::find()->where(['member_id'=>$id])->all();
                //循环遍历修改保存状态
                foreach($rows as $row){
                    $row->status = 0;
                    $row->save();
                }
            }
            //var_dump($model);exit;
            //保存数据
            $model->save();
            //给用户一个提示
            \Yii::$app->session->setFlash('success','保存成功');
            return $this->redirect(['address/index']);
        }

        return $this->render('index',['model'=>$model,'rows'=>$rows]);
    }


    //删除收货地址
    public function actionDel($id)
    {
        Address::findOne($id)->delete();
        //删除成功给用户一个提示
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['address/index']);
    }


    //修改收货地址
    public function actionEdit($id)
    {
        $model = Address::findOne($id);
        //接收数据
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //一一赋值给model中的对应字段
            $row = $_POST;
            $model->province = $row['cmbProvince'];
            $model->city = $row['cmbCity'];
            $model->area = $row['cmbArea'];
            //判断是否设置为默认
            if($model->status){
                //查出该用户所有的收货地址
                $rows = Address::find()->where(['member_id'=>$model->member_id])->all();
                //循环遍历修改保存状态
                foreach($rows as $row){
                    $row->status = 0;
                    $row->save();
                }
            }
            //var_dump($model);exit;
            //保存数据
            $model->save();
            //给用户一个提示
            \Yii::$app->session->setFlash('success','保存成功');
            return $this->redirect(['address/index']);
        }
        return $this->render('edit',['model'=>$model]);
    }


    //修改默认收货地址
    public function actionStatus($id)
    {
        $model = Address::findOne($id);
        //查出该用户所有的收货地址
        $rows = Address::find()->where(['member_id'=>$model->member_id])->all();
        //循环遍历修改保存状态
        foreach($rows as $row){
            if($row->id == $id){
                $row->status = 1;
                $row->save();
            }else{
                $row->status = 0;
                $row->save();
            }
        }
        \Yii::$app->session->setFlash('success','默认地址设置成功');
        return $this->redirect(['address/index']);
    }
}

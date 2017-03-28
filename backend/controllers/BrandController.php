<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Request;
use yii\web\UploadedFile;

class BrandController extends \yii\web\Controller
{
    //显示品牌列表
    public function actionIndex()
    {
        $query = Brand::find();
        $pager = new Pagination([
            'totalCount'=>$query->count(),
            'pageSize'=>3,
        ]);
        $rows =$query->where(['>=','status',0])->limit($pager->limit)->offset($pager->offset)->all();//判断是否为删除状态

        return $this->render('index',['rows'=>$rows,'pager'=>$pager]);
    }
    //添加品牌
    public function actionAdd(){
        //实例模型
        $model = new Brand();

        $request = new Request();
        //判断传值方式进行不同的操作
        if($request->isPost){
            //加载数据
            $model->load($request->post());
            //处理上传图片
            $model->logo_file = UploadedFile::getInstance($model,'logo_file');
            //判断是否通过验证规则
            if($model->validate()){
                $filename = 'upload/brand/'.uniqid().'.'.$model->logo_file->extension;
                //保存图片,如果成功就把路径添加进去
                if($model->logo_file->saveAs($filename,false)){
                    $model->logo = $filename;
                }
                //保存数据
                $model->save();
                \yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['brand/index']);
            }
        }
        //展示添加表单
        return $this->render('add',['model'=>$model]);
    }
    //修改品牌
    public function actionEdit($id)
    {
        //查出数据
        $model = Brand::findOne($id);
        $request = new Request();
        //判断传值方式进行不同的操作
        if($request->isPost){
            //加载数据
            $model->load($request->post());
            //处理上传图片
            $model->logo_file = UploadedFile::getInstance($model,'logo_file');
            //判断是否通过验证规则
            if($model->validate()){
                $filename = 'upload/brand/'.uniqid().'.'.$model->logo_file->extension;
                //保存图片,如果成功就把路径添加进去
                if($model->logo_file->saveAs($filename,false)){
                    $model->logo = $filename;
                }
                //保存数据
                $model->save();
                \yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['brand/index']);
            }
        }
        //展示添加表单
        return $this->render('add',['model'=>$model]);
    }
    //逻辑删除数据
    public function actionDel($id)
    {
        //查出数据
        $model = Brand::findOne($id);
        //修改状态
        $model->status = '-1';
        //保存到数据库
        $model->save(false);

        return $this->redirect(['brand/index']);
    }
    //回收站,所有被逻辑删除的数据
    public function actionRubbish()
    {
        $query = Brand::find();
        $pager = new Pagination([
           'totalCount'=>$query->count(),
           'pageSize'=>3,
        ]);
        //查出数据
        $rows = $query->where(['status'=>'-1'])->limit($pager->limit)->offset($pager->offset)->all();
        //展示页面
        return  $this->render('rubbish',['rows'=>$rows,'pager'=>$pager]);

    }
    //撤销删除
    public function actionRevoke($id)
    {
        //查出数据
        $model = Brand::findOne($id);
        //修改状态
        $model->status = '1';
        //保存到数据库
        $model->save(false);

        return $this->redirect(['brand/rubbish']);
    }
    //彻底删除
    public function actionDelete($id){
        Brand::findOne($id)->delete();
        return $this->redirect(['brand/rubbish']);
    }

}

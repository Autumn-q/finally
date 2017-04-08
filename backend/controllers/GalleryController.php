<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\GoodsGallery;
use yii\web\Request;
use yii\web\UploadedFile;

class GalleryController extends \yii\web\Controller
{
    //添加过滤器
    public function behaviors()
    {
        return [
            'accessAction'=>[
                'class'=>AccessFilter::className(),
                'only'=>['index','add','del',],
            ],
        ];

    }
    public function actionIndex($id)
    {
        $rows = GoodsGallery::find()->where(['goods_id'=>$id])->all();

        return $this->render('index',['rows'=>$rows,'goods_id'=>$id]);
    }
    //多文件上传的方法
    public function actionAdd($goods_id)
    {
        $model = new GoodsGallery();
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());

            //处理上传图片
            $model->imgFile = UploadedFile::getInstances($model,'imgFile');
            //验证
            if($model->validate()){
                //多文件上传,所以是个数组,遍历保存
                foreach($model->imgFile as $file){
                    //设置保存路径
                    $filename = 'upload/goods/gallery/'.uniqid().'.'.$file->extension;

                    if($file->saveAs($filename,false)){
                        //如果保存成功,就把路径保存到数据库里
                        \yii::$app->db->createCommand()->insert('goods_gallery',[
                            'goods_id'=>$goods_id,
                            'path'=>$filename,
                        ])->query();
                        /*$model->path = $filename;
                        $model->goods_id = $goods_id;*/

                    }else{
                        //失败也给用户一个提示
                        \yii::$app->session->setFlash('success','上传失败,请在相册再次添加');
                        //跳转到相册首页
                        return $this->redirect(['goods/gallery?goods_id='.$goods_id]);
                    }
                }
                //给用户一个提示
                \yii::$app->session->setFlash('success','上传成功');
                //跳转到商品首页
                return $this->redirect(['gallery/index?id='.$goods_id]);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    //删除的方法
    public function actionDel($id,$goods_id)
    {
        GoodsGallery::findOne(['id'=>$id])->delete();
        return $this->redirect(['gallery/index?id='.$goods_id]);
    }
    //多文件上传的修改方法
  /*  public function actionEdit($id,$goods_id)
    {
    $model = GoodsGallery::findOne($id);
    $request = new Request();
    if($request->isPost){
        $model->load($request->post());

        //处理上传图片
        $model->imgFile = UploadedFile::getInstances($model,'imgFile');
        //验证
        if($model->validate()){
            //多文件上传,所以是个数组,遍历保存
            foreach($model->imgFile as $file){
                //设置保存路径
                $filename = 'upload/goods/gallery/'.uniqid().'.'.$file->extension;

                if($file->saveAs($filename,false)){
                    //如果保存成功,就把路径保存到数据库里
                    \yii::$app->db->createCommand()->insert('goods_gallery',[
                        'goods_id'=>$goods_id,
                        'path'=>$filename,
                    ])->query();

                }else{
                    //失败也给用户一个提示
                    \yii::$app->session->setFlash('success','修改失败');
                    //跳转到相册首页
                    return $this->redirect(['goods/index?id='.$goods_id]);
                }
            }
            //给用户一个提示
            \yii::$app->session->setFlash('success','修改成功');
            //跳转到商品首页
            return $this->redirect(['gallery/index?id='.$goods_id]);
        }
    }
    return $this->render('add',['model'=>$model]);
    }*/


}

<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use backend\models\GoodsSearchForm;
use xj\uploadify\UploadAction;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\web\Request;
use yii\web\UploadedFile;

class GoodsController extends \yii\web\Controller
{
    //添加过滤器
    public function behaviors()
    {
        return [
            'accessAction'=>[
                'class'=>AccessFilter::className(),
                'only'=>['upload','index','add','edit','del','save','rubbish','delete'],
                ],
            ];

    }
    //增加上传文件的插件
    public function actions() {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ],
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload/brand',
                'baseUrl' => '@web/upload/brand',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                //'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                /*'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },*/
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    //$action->getFilename(); // "image/yyyymmddtimerand.jpg"
                    // $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                    // $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg

                },
            ],
        ];
    }
    public function actionIndex()
    {
        $query = Goods::find()->where(['status'=>1]);
        //调用搜索的方法
        $model = new GoodsSearchForm();
        $model->load(\yii::$app->request->get());
        $model->search($query);

        //实例分页对象,并传入参数
        $pager = new Pagination([
            'totalCount'=>$query->count(),
            'pageSize'=>3,
        ]);
        //查出数据
        $rows =$query->limit($pager->limit)->offset($pager->offset)->all();

        //展示页面
        return $this->render('index',['rows'=>$rows,'pager'=>$pager,'model'=>$model]);

    }
    //添加商品
    public function actionAdd()
    {
        $model = new Goods();
        $models = new GoodsIntro();
        $request = new Request();
        //实例一个上传文件的模型
        if($request->isPost && $model->load($request->post()) && $models->load($request->post())){
            //判断深度,只能在三级分类下添加商品
            if($model->depth!=3){
                \yii::$app->session->setFlash('danger','只能在最3级分类下添加商品');
                return $this->redirect(['goods/add']);
            }else{
                //处理上传图片
                $model->logo_file = UploadedFile::getInstance($model,'logo_file');

                //验证数据
                if($model->validate()){
                    //验证通过保存图片
                    $filename = 'upload/goods/logo/'.uniqid().'.'.$model->logo_file->extension;
                    if($model->logo_file->saveAs($filename,false)){
                        //保存成功,把路径添加到model中
                        $model->logo = $filename;
                    }
                    //给goods_day_count添加一条数据
                    $day_count = new GoodsDayCount();
                    $day_count->day = date('Y-m-d');
                    $result = $day_count->findOne($day_count->day);

                    //判断当天是否有记录了
                    if($result){
                        //如果有了就数量就加1
                        $result->count++;
                        $result->save();
                        $model->sn = $result->count;
                        $model->sn = date('Ymd').'0000'.$result->count;

                    }else{
                        //没有就新添加一个
                        $day_count->count = 1;

                        $day_count->save();
                        $model->sn = date('Ymd').'0000'.$day_count->count;
                    }
                    $model->inputtime = time();
                    $model->save();

                    //商品保存后,保存商品详情表信息,得到商品id
                    $models->goods_id = $model->id;
                    $models->save();

                    \yii::$app->session->setFlash('success','添加成功');
                    return $this->redirect('gallery/add?goods_id='.$model->id);
                }
            }

        }
        //查出商品分类数据,并展示出来
        $rows = GoodsCategory::find()->all();
        //转化成json数据传过去
        $rows = Json::encode($rows);
        //展示添加界面
        return $this->render('add',['model'=>$model,'rows'=>$rows,'models'=>$models]);
    }
    //修改商品信息
    public function actionEdit($id)
    {
        $model = Goods::findOne($id);
        $models = GoodsIntro::findOne(['goods_id'=>$id]);
        $request = new Request();
        //实例一个上传文件的模型
        if($request->isPost && $model->load($request->post()) && $models->load($request->post())){
            //判断深度,只能在三级分类下添加商品
            if($model->depth!=3){
                \yii::$app->session->setFlash('danger','只能在最3级分类下添加商品');
                return $this->redirect(['goods/add']);
            }else{
                //处理上传图片
                $model->logo_file = UploadedFile::getInstance($model,'logo_file');

                //验证数据
                if($model->validate()){
                    //验证通过保存图片
                    $filename = 'upload/goods/logo/'.uniqid().'.'.$model->logo_file->extension;
                    if($model->logo_file->saveAs($filename,false)){
                        //保存成功,把路径添加到model中
                        $model->logo = $filename;
                    }
                    //给goods_day_count添加一条数据
                    $day_count = new GoodsDayCount();
                    $day_count->day = date('Y-m-d');
                    $result = $day_count->findOne($day_count->day);

                    //判断当天是否有记录了
                    if($result){
                        //如果有了就数量就加1
                        $result->count++;
                        $result->save();
                        $model->sn = $result->count;
                        $model->sn = date('Ymd').'0000'.$result->count;

                    }else{
                        //没有就新添加一个
                        $day_count->count = 1;

                        $day_count->save();
                        $model->sn = date('Ymd').'0000'.$day_count->count;
                    }
                    $model->inputtime = time();
                    $model->save();

                    //商品保存后,保存商品详情表信息,得到商品id
                    $models->goods_id = $model->id;
                    $models->save();

                    \yii::$app->session->setFlash('success','修改成功');
                    return $this->redirect(['goods/index']);
                }
            }

        }
        //查出商品分类数据,并展示出来
        $rows = GoodsCategory::find()->all();
        //转化成json数据传过去
        $rows = Json::encode($rows);
        //展示添加界面
        return $this->render('add',['model'=>$model,'rows'=>$rows,'models'=>$models]);
    }
    //逻辑删除
    public function actionDel($id)
    {
        //查出数据
        $rs = Goods::findOne($id);
        //修改状态
        $rs->status =0;
        //保存状态
        $rs->save(false);
        //返回首页
        return $this->redirect(['goods/index']);
    }
    //展示相册
    public function actionRubbish()
    {
        $query = Goods::find()->where(['status'=>0]);
        //调用搜索的方法
        $model = new GoodsSearchForm();
        $model->load(\yii::$app->request->get());
        $model->search($query);

        //实例分页对象,并传入参数
        $pager = new Pagination([
            'totalCount'=>$query->count(),
            'pageSize'=>3,
        ]);
        //查出数据
        $rows =$query->limit($pager->limit)->offset($pager->offset)->all();

        //展示页面
        return $this->render('rubbish',['rows'=>$rows,'pager'=>$pager,'model'=>$model]);
    }
    //撤销删除
    public function actionSave($id)
    {
        //查出数据
        $rs = Goods::findOne($id);
        //修改状态
        $rs->status =1;
        //保存状态
        $rs->save(false);
        //返回首页
        return $this->redirect(['goods/rubbish']);
    }
    //彻底删除
    public function actionDelete($id)
    {
        //查出数据并删除
        Goods::findOne($id)->delete();
        //返回回收站
        return $this->redirect(['goods/rubbish']);
    }

}

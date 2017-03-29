<?php

namespace backend\controllers;

use backend\models\ArticleCategory;
use yii\data\Pagination;
use yii\web\Request;

class ArticleCategoryController extends \yii\web\Controller
{
    //展示页面
    public function actionIndex()
    {
        $query = ArticleCategory::find();
        $pager = new Pagination([
            'totalCount'=>$query->count(),
            'pageSize'=>3,
        ]);
        $rows =$query->limit($pager->limit)->offset($pager->offset)->all();

        return $this->render('index',['rows'=>$rows,'pager'=>$pager]);
    }
    //添文章分类加
    public function actionAdd()
    {
        //实例模型
        $model = new ArticleCategory();

        $request = new Request();
        //判断传值方式进行不同的操作
        if($request->isPost){
            //加载数据
            $model->load($request->post());

            //判断是否通过验证规则
            if($model->validate()){
                //保存数据
                $model->save();
                \yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article-category/index']);
            }
        }
        //展示添加表单
        return $this->render('add',['model'=>$model]);
    }
    //修改文章分类
    //添文章分类加
    public function actionEdit($id)
    {
        //实例模型
        $model = ArticleCategory::findOne($id);

        $request = new Request();
        //判断传值方式进行不同的操作
        if($request->isPost){
            //加载数据
            $model->load($request->post());

            //判断是否通过验证规则
            if($model->validate()){
                //保存数据
                $model->save();
                \yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['article-category/index']);
            }
        }
        //展示修改表单
        return $this->render('add',['model'=>$model]);
    }
    //删除文章分类
    public function actionDel($id)
    {
        ArticleCategory::findOne($id)->delete();
        //删除后跳转到首页
        return $this->redirect(['article-category/index']);
    }

}

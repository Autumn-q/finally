<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleDetail;
use yii\data\Pagination;
use yii\web\Request;

class ArticleController extends \yii\web\Controller
{
    //展示文章列表
    public function actionIndex()
    {

        $query = Article::find();
        $pager = new Pagination([
            'totalCount'=>$query->count(),
            'pageSize'=>3,
        ]);
        $rows =$query->limit($pager->limit)->offset($pager->offset)->all();

        return $this->render('index',['rows'=>$rows,'pager'=>$pager]);
    }
    //添加文章
    public function actionAdd()
    {
        //实例模型
        $model = new Article();

        $request = new Request();
        //判断传值方式进行不同的操作
        if($request->isPost){
            //加载数据
            $model->load($request->post());

            //判断是否通过验证规则
            if($model->validate()){
                //保存数据
                $model->inputtime = time();
                $model->save();
                //获取刚添加数据的id
                $id = \yii::$app->db->getLastInsertID();
                //实例文章内容表对象
                $detail = new ArticleDetail();
                //给字段内容赋值
                $detail->article_id = $id;
                $detail->content = $model->content;
                //保存到数据库
                $detail->save();
                \yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article/index']);
            }
        }
        //展示添加表单
        return $this->render('add',['model'=>$model]);
    }
    //修改文章
    public function actionEdit($id)
    {
        //实例模型
        $model = Article::findOne($id);
        $detail = ArticleDetail::findOne($id);

        //把内容给文章表里 用于回显
        $model->content = $detail->content;
        $request = new Request();
        //判断传值方式进行不同的操作
        if($request->isPost){
            //加载数据
            $model->load($request->post());

            //判断是否通过验证规则
            if($model->validate()){
                //保存数据
                $model->save();
                //给字段内容赋值
                $detail->article_id = $id;
                $detail->content = $model->content;
                //保存到数据库
                $detail->save();
                \yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['article/index']);
            }
        }
        //展示添加表单
        return $this->render('add',['model'=>$model]);
    }
    //删除文章
    public function actionDel($id)
    {
        Article::findOne($id)->delete();
        ArticleDetail::findOne($id)->delete();
        //删除后跳转到首页
        return $this->redirect(['article/index']);
    }

}

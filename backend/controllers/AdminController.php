<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\Admin;
use backend\models\AdminForm;
use yii\filters\AccessControl;
use yii\web\Request;

class AdminController extends \yii\web\Controller
{
    //添加过滤器
    /*public function behaviors()
    {
        return [
            'accessAction'=>[
                'class'=>AccessFilter::className(),
                'only'=>['index','add','del','edit','register','login','logout'],
            ],
        ];

    }*/
    public function actionIndex()
    {
        $rows = Admin::find()->all();
        return $this->render('index',['rows'=>$rows]);
    }

    /*//用户注册方法
    public function actionRegister()
    {
        //实例模型
        $model = new Admin();
        $request = new Request();
        //判断接收方法和验证
        if ($request->isPost && $model->load($request->post())) {
            //添加字段
            $model->add_time = time();

            if ($model->validate()) {
                //给密码加盐
                $model->auth_key = \yii::$app->security->generateRandomString();
                $model->password = \yii::$app->security->generatePasswordHash($model->password);
                $model->last_login_time = time();
                $model->last_login_ip = $_SERVER['REMOTE_ADDR'];
                $model->add_time = time();
                //把用户和角色名关系保存到数据库,先实例化对象
                $authManager = \yii::$app->authManager;
                    //找到角色对象,因为是用户自己注册,所以给个默认角色
                    $role = $authManager->getRole('admin');
                    $authManager->assign($role,$model->id);
                //给用户一个提示
                \yii::$app->user->login($model);
                \yii::$app->session->setFlash('success', '注册成功');
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('add', ['model' => $model]);
    }*/
    //用户添加的方法
    public function actionAdd()
    {
        //实例模型
        $model = new Admin();
        $request = new Request();
        //判断接收方法和验证
        if ($request->isPost && $model->load($request->post())) {
            //添加字段
            $model->add_time = time();

            if ($model->validate()) {
                $model->auth_key = \yii::$app->security->generateRandomString();
                //给密码加盐
                $model->password = \yii::$app->security->generatePasswordHash($model->password);
                $model->add_time = time();
                $model->save(false);
                //把用户和角色名关系保存到数据库,先实例化对象
                $authManager = \yii::$app->authManager;
                foreach($model->role as $role){
                    //找到角色对象
                    $rs = $authManager->getRole($role);
                    $authManager->assign($rs,$model->id);
                }
                //给用户一个提示
                \yii::$app->user->login($model);
                \yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('add', ['model' => $model]);
    }
    //用户修改方法
    public function actionEdit($id)
    {
        //实例模型
        $authManager = \Yii::$app->authManager;
        $model = Admin::findOne($id);
        //查出所属角色
        $rs = $authManager->getRolesByUser($id);

        $model->role = array_keys($rs);

        $request = new Request();
        //判断接收方法和验证
        if ($request->isPost && $model->load($request->post())) {
            //添加字段

            if ($model->validate()) {
                //给密码加盐
                $model->password = \yii::$app->security->generatePasswordHash($model->password);

                $model->save(false);

                //先删除所有的角色和用户关系
                $authManager->revokeAll($id);

                //重新关联角色和用户关系
                foreach($model->role as $role){

                    //找到角色对象
                    $rs = $authManager->getRole($role);
                    $authManager->assign($rs,$model->id);
                }
                //给用户一个提示
                \yii::$app->session->setFlash('success', '修改成功');
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('add', ['model' => $model]);
    }
    //删除的方法
    public function actionDel($id)
    {
        Admin::findOne($id)->delete();
        $authManager = \Yii::$app->authManager;
        $authManager->revokeAll($id);
        \yii::$app->session->setFlash('danger', '删除成功');
        return $this->redirect(['admin/index']);
    }

    //登录的方法
    public function actionLogin()
    {
        $model = new AdminForm();

        $request = new Request();

        //判断传值
        if ($request->isPost) {
            //加载数据
            $model->load($request->post());
            //调用模型上的方法,帮我验证登录信息
            if ($model->login()) {
                //验证通过

                \yii::$app->session->setFlash('success', '登录成功');
                return $this->redirect(['admin/index']);
            }

        }
        return $this->render('login', ['model' => $model]);
    }
    public function actionGuest()
    {
        //可以通过 Yii::$app->user 获得一个 User实例，
        $user = \Yii::$app->user;

        // 当前用户的身份实例。未认证用户则为 Null 。
        $identity = \Yii::$app->user->identity;
        var_dump($identity);
        // 当前用户的ID。 未认证用户则为 Null 。
        $id = \Yii::$app->user->id;
        var_dump($id);
        // 判断当前用户是否是游客（未认证的）
        $isGuest = \Yii::$app->user->isGuest;
        var_dump($isGuest);
    }
    //注销登录
    public function actionLogout()
    {
        \yii::$app->user->logout();
        //给用户一个提示
        \yii::$app->session->setFlash('danger','注销成功');
        return $this->redirect(['admin/login']);
    }
    public function behaviors()
    {
        return [
          'ACF'=>[
              'class'=>AccessControl::className(),
              'only'=>['index','add','del','edit','register','login','logout'],
              'rules'=>[
                  [
                  'allow'=>true,
                  'actions'=>['index','add','del','edit','logout'],
                  'roles'=>['@'],
                  ],
                  [
                    'allow'=>true,
                    'actions'=>['register','login'],
                    'roles'=>['?'],
                  ],

              ],

          ],
        ];
    }
    public function actions() {
        return [
            'captcha' =>  [
                'class' => 'yii\captcha\CaptchaAction',
                'height' => 50,
                'width' => 80,
                'minLength' => 4,
                'maxLength' => 4
            ],
        ];
    }

}

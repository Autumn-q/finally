<?php

namespace frontend\controllers;

use frontend\models\Member;
use frontend\models\MemberForm;
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;
use yii\helpers\Json;


class MemberController extends \yii\web\Controller
{
    public $layout = 'login';//指定布局文件
    public function actionIndex()
    {
        return 'index';
    }
    //用户注册
    public function actionRegister()
    {
        $model = new Member();
        //接收传值并验证
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //添加注册时间,自动登录令牌,密码加盐
            $model->password = \yii::$app->security->generatePasswordHash($model->password);
            $model->create_add = time();
            $model->auth_key = \Yii::$app->security->generateRandomString();
            $model->save(false);
            \Yii::$app->session->setFlash('success','注册成功');
            return $this->redirect(['member/index']);
        }
        return $this->render('register',['model'=>$model]);
    }
    //用户登录
    public function actionLogin()
    {
        $model = new MemberForm();
        //接收数据,并验证
        if($model->load(\Yii::$app->request->post())){

            //验证登录信息
            if($model->login()){
                \Yii::$app->session->setFlash('success','登录成功');
                return $this->redirect(['index/index']);
            }
        }

        return $this->render('login',['model'=>$model]);
    }
    //短信验证
    public function actionSms()
    {

        // 配置信息
        $config = [
            'app_key' => '23742112',
            'app_secret' => '7eb3cfd3503730e0ff772ca9bd817e44',
            // 'sandbox'    => true,  // 是否为沙箱环境，默认false
        ];
        //接收电话号码
        $tel = \Yii::$app->request->post('tel');
        //实现发送短信验证码
        $client = new Client(new App($config));
        $req    = new AlibabaAliqinFcSmsNumSend;
        $code = rand(0000,9999);
        $req->setRecNum($tel)
            ->setSmsParam([
                'content' => $code
            ])
            ->setSmsFreeSignName('惊喜商场')
            ->setSmsTemplateCode('SMS_60980117');

        $resp = $client->execute($req);
        //保存到session中
        \Yii::$app->session->set('tel_'.$tel,$code);
        return Json::encode([
            'error'=>0,
            'msg'=>'短信发送成功',
        ]);
    }
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->redirect(['member/login']);
    }

}

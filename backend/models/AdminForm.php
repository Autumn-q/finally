<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/2
 * Time: 11:26
 */

namespace backend\models;


use yii\base\Model;
use yii\db\Query;

class AdminForm extends Model
{
    public $username;
    public $password;
    public $remember;
    public $verifyCode;


    //规则
    public function rules()
    {
        return [
            [['username','password'],'required'],
            ['remember','safe'],
            ['verifyCode','captcha','message'=>'验证码错误', 'captchaAction'=>'admin/captcha']
        ];
    }
    //设置属性
    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码',
            'remember'=>'下次自动登录',
            'verifyCode'=>'验证码',
        ];
    }
    //验证登录
    public function login()
    {

        //判断验证
        if($this->validate()){
            //验证用户名密码是否一致
           $admin = Admin::findOne(['username'=>$this->username])?Admin::findOne(['username'=>$this->username]):Admin::findOne(['email'=>$this->username]);

            //判断是否有这个用户名
            if($admin){

                if(\yii::$app->security->validatePassword($this->password,$admin->password)){

                    //验证通过保存session,并把最后登录时间和ip保存到数据库
                    $admin_1 = Admin::findOne(['id'=>$admin->id]);
                    $admin_1->last_login_time = time();
                    $admin_1->last_login_ip = $_SERVER['REMOTE_ADDR'];
                    $admin_1->save(false);

                    \yii::$app->user->login($admin,$this->remember?3600*30*24:0);

                    return true;
                }else{

                    //验证失败
                    $this->addError('密码输入错误');
                }
            }else{

                //如果没有找到给用户一个提示
                $this->addError('用户名不存在');
            }
        }

        return false;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/9
 * Time: 13:24
 */

namespace frontend\models;


use yii\base\Model;

class MemberForm extends Model
{
    public $username;
    public $password;
    public $remember;
    public $code;

    //验证规则
    public function rules()
    {
        return [
            [['username', 'password',], 'required'],
            //['code','captcha','message'=>'验证码错误'],
            ['remember','safe'],
        ];
    }
    public function attributeLabels()
    {
        return[
          'username'=>'用户名：',
          'password'=>'密码：',
          'remember'=>'记住我',
          'code'=>'验证码：',
        ];
    }
    //验证登录信息
    public function login()
    {
        if($this->validate()){
            $member = Member::findOne(['username'=>$this->username])?Member::findOne(['username'=>$this->username]):Member::findOne(['email'=>$this->username]);
            //如果有查到数据,那么就验证密码
            if($member){
                //如果密码正确,就保存到session中,返回true
                if(\yii::$app->security->validatePassword($this->password,$member->password)){

                    //验证成功,把最后登录ip和最后登录时间添加到数据库
                    $member->last_login_time = time();
                    $member->last_login_ip = $_SERVER['REMOTE_ADDR'];
                    $member->save(false);
                    \Yii::$app->user->login($member,$this->remember?3600*24*7:0);
                    \Yii::$app->session->setFlash('success','登录成功');
                    //如果用户是加入购入车后中途登录,那么需要在登录后,把购物车信息保存到数据库
                    $member_id = \Yii::$app->user->id;
                    $cookies = \Yii::$app->request->cookies;
                    $cookie = $cookies->get('cart');

                    //判断是否有这个cookie的数组
                    if($cookie == null){
                        $cart = [];
                    }else{
                        //反序列化成数组
                        $cart = unserialize($cookie->value);
                        //判断该用户是否有这个商品的购物车记录
                        $model = new Cart();
                        //数组中可能有多个商品和数量,所以要循环比较查询添加
                        foreach($cart as $k=>$v){
                            $result = $model->find()->where(['goods_id'=>$k])->andWhere(['member_id'=>$member_id])->one();
                            //var_dump($result);exit;
                            if($result){
                                //如果有就在原有的基础上加
                                $result->amount += $v;
                                $result->save();
                            }else{
                                //如果没有就添加
                                $model->amount = $v;
                                $model->goods_id = $k;
                                $model->member_id = $member_id;
                                $model->insert();
                            }
                        }

                    }

                    return true;
                }
                $this->addError('password','密码错误');
            }
            $this->addError('username','用户名错误');
        }
        return false;
    }
}
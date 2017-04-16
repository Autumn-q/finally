<?php

namespace frontend\controllers;

use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Goods;
use frontend\models\Order;
use frontend\models\OrderDetail;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

class OrderController extends \yii\web\Controller
{

    public function actionIndex()
    {
        //指定模板
         $this->layout = 'cart';
        //判断是否登录,如果没有则需要先登录
        if(\Yii::$app->user->isGuest){
            return $this->redirect('member/login');
        }
        //获取当前登录用户id
        $member_id = \Yii::$app->user->id;
        //根据用户id查出该用户的所有地址
        $addresses = Address::find()->where(['member_id'=>$member_id])->all();

        //根据用户id查出购物车里的商品信息
        $carts = Cart::find()->where(['member_id'=>$member_id])->all();

        //根据商品id查出该商品的信息
        $rows = [];
        foreach($carts as $v){
            $goods=Goods::find()->where(['id'=>$v->goods_id])->asArray()->one();
            $goods['amount'] = $v->amount;
            $rows[]=$goods;
        }
        $token = \Yii::$app->request->csrfToken;
        return $this->render('index',['addresses'=>$addresses,'rows'=>$rows,'token'=>$token]);
    }
    //添加订单
    public function actionAdd(){
        //找到当前登录用户的id
        $member_id = \Yii::$app->user->id;
        //实例订单对象

        $order = new Order();
        $address_id = \Yii::$app->request->post('address_id');

        //查出收货信息
        $address = Address::findOne($address_id);

        //赋值
        $order->member_id = $member_id;
        $order->name = $address->name;
        $order->province = $address->province;
        $order->city = $address->city;
        $order->area = $address->area;
        $order->address = $address->address;
        $order->tel = $address->tel;

        //将配送方式找到赋值
        $delivery = Order::$deliveries;
        $order->delivery_id = \Yii::$app->request->post('delivery_id');
        $order->delivery_name = $delivery[$order->delivery_id][0];
        $order->delivery_price = $delivery[$order->delivery_id][1];

        //将付款方式找到赋值
        $payments = Order::$payments;
        $order->pay_type_id = \Yii::$app->request->post('pay_type_id');
        $order->pay_type_name = $payments[$order->pay_type_id][0];

        //计算总价
        //根据用户id查出购物车里的商品信息
        $carts = Cart::find()->where(['member_id'=>$member_id])->all();

        //根据商品id查出该商品的信息
        $price = 0;
        foreach($carts as $v){
            $goods=Goods::find()->where(['id'=>$v->goods_id])->one();
            $price += $goods->shop_price*$v->amount;
            $price += $order->delivery_price;
        }
        $order->price = $price;
        $order->status = $order->pay_type_id;
        $order->create_time = time();
        //var_dump($order);exit;
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();
        try{
            $order->save();

            //准备保存数据到订单详情表
            $order_detail = new OrderDetail();
            foreach($carts as $v){
                $goods=Goods::find()->where(['id'=>$v->goods_id])->one();
                //赋值
                $order_detail->order_info_id = $order->id;
                $order_detail->goods_id = $goods->id;
                $order_detail->goods_name = $goods->name;
                $order_detail->logo = $goods->logo;
                $order_detail->price = $goods->shop_price;
                $order_detail->amount = $v->amount;
                $order_detail->total_price = $goods->shop_price*$v->amount;

                if($v->amount > $goods->stock){
                    throw new Exception('商品'.$goods->name.'库存不足,请修改数量后重新下单');
                }
                $goods->stock -= $v->amount;
                $goods->save();
                $order_detail->save();

            }
            $transaction->commit();
            //保存成功跳到提示页面
            return $this->redirect(['order/success']);

        }catch (Exception $e){
                \Yii::$app->session->setFlash('danger',$e->getMessage());
                $transaction->rollBack();
                return $this->redirect(['cart/index']);

        }

    }
    public function actionSuccess(){
        return $this->render('success');
    }

}

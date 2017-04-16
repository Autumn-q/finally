<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $name
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $address
 * @property string $tel
 * @property integer $delivery_id
 * @property string $delivery_name
 * @property string $delivery_price
 * @property integer $pay_type_id
 * @property string $pay_type_name
 * @property string $price
 * @property integer $status
 * @property string $trade_no
 * @property integer $create_time
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    //快递方式
    public static $deliveries=[
      1=>['EMS','10','货物可能落入黑洞'],
      2=>['特快','50','炒鸡快'],
      3=>['普通快递','15','3-7天送达'],
    ];
    //付款方式
    public static $payments=[
        1=>['货到付款','送货上门,支持pos机刷卡,现金'],
        2=>['支付宝','方便快捷,在线支付'],
        3=>['微信支付','方便快捷,在线支付'],
        4=>['银联支付','方便快捷,在线支付'],
    ];
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'delivery_id', 'pay_type_id', 'status', 'create_time'], 'integer'],
            [['delivery_price', 'price'], 'number'],
            [['name'], 'string', 'max' => 20],
            [['province', 'city', 'area', 'delivery_name', 'pay_type_name', 'trade_no'], 'string', 'max' => 30],
            [['address'], 'string', 'max' => 40],
            [['tel'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '会员id',
            'name' => '收货人',
            'province' => '省份',
            'city' => '城市',
            'area' => '区县',
            'address' => '详细地址',
            'tel' => '手机号',
            'delivery_id' => '配送方式id',
            'delivery_name' => '配送方式名字',
            'delivery_price' => '配送费',
            'pay_type_id' => '支付方式id',
            'pay_type_name' => '支付方式名字',
            'price' => '商品价格',
            'status' => '订单状态',
            'trade_no' => '第三方交易方式',
            'create_time' => '创建时间',
        ];
    }
}
